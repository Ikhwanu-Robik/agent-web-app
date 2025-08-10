<?php

namespace App\Models;

use App\Enums\FlipStep;
use App\Models\Voucher;
use App\Enums\FlipBillType;
use App\Models\BusSchedule;
use App\Facades\FlipTransaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class BusTicketTransaction extends Model
{
    protected $fillable = [
        "user_id",
        "bus_schedule_id",
        "ticket_amount",
        "total",
        "method",
        "status",
        "flip_link_id"
    ];

    public function busSchedule()
    {
        return $this->belongsTo(BusSchedule::class);
    }

    public static function createOrder(array $validated)
    {
        $busSchedule = BusSchedule::find($validated["schedule_id"]);

        $attribute = [
            "user_id" => Auth::id(),
            "bus_schedule_id" => $validated["schedule_id"],
            "ticket_amount" => $validated["ticket_amount"],
            "total" => $validated["ticket_amount"] * $busSchedule->ticket_price,
            "method" => null,
            "status" => null,
            "flip_link_id" => null
        ];
        $transaction = self::make($attribute);

        return $transaction;
    }

    public function appendBusScheduleDetails()
    {
        $busScheduleDetail = BusSchedule::with(["bus", "originStation", "destinationStation"])
            ->findOrFail($this->bus_schedule_id);
        $this->busSchedule = $busScheduleDetail;
    }

    public function calculateTotal($busSchedule, $ticketAmount, $voucherId)
    {
        $voucher = Voucher::find($voucherId);

        // get the final price percentage
        // delete the voucher
        $discount = 1;
        if ($voucher) {
            $discount = (100 - $voucher->off_percentage) / 100;

            $voucher->delete();
        }

        // get the final price in nominal
        $total = $ticketAmount * $busSchedule->ticket_price * $discount;

        $this->total = $total;

        return $voucher;
    }

    public function processPayment(array $validated)
    {
        $busSchedule = BusSchedule::with(["bus", "originStation", "destinationStation"])
            ->findOrFail($validated["bus_schedule_id"]);
        
        $voucher = $this->calculateTotal(
            $busSchedule,
            $validated["ticket_amount"],
            $validated["voucher"]
        );


        $flipResponse = null;
        $this->status = "PENDING";
        if ($validated["payment_method"] == "cash") {
            $this->method = "cash";
            $this->status = "SUCCESSFUL";
        } else if ($validated["payment_method"] == "flip") {
            $response = FlipTransaction::createFlipBill(
                "Bus Ticket - {$busSchedule->bus->name} - {$busSchedule->origin_station->name} - {$busSchedule->destination_station->name}",
                FlipBillType::SINGLE,
                $this->total,
                FlipStep::INPUT_DATA,
                "/bus/ticket"
            );

            $this->method = "flip";
            $this->flip_link_id = $response["flip_link_id"];

            $flipResponse = $response;
        }

        $paymentData = [
            "flip_response" => $flipResponse,
        ];

        unset($this->busSchedule);
        $this->save();

        $this->busSchedule = $busSchedule;
        if ($voucher) {
            $this->voucher = $voucher->off_percentage . "%";
        }

        return $paymentData;
    }
}
