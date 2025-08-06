<?php

namespace App\Models;

use App\Enums\FlipStep;
use App\Models\Voucher;
use App\Enums\FlipBillType;
use App\Models\BusSchedule;
use App\Services\FlipTransaction;
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
        $bus_schedule = BusSchedule::find($validated["schedule_id"]);

        $attribute = [
            "user_id" => Auth::id(),
            "bus_schedule_id" => $validated["schedule_id"],
            "ticket_amount" => $validated["ticket_amount"],
            "total" => $validated["ticket_amount"] * $bus_schedule->ticket_price,
            "method" => null,
            "status" => null,
            "flip_link_id" => null
        ];
        $transaction = self::make($attribute);

        return $transaction;
    }

    public function appendBusScheduleDetails()
    {
        $bus_schedule_detail = BusSchedule::with(["bus", "originStation", "destinationStation"])
            ->findOrFail($this->bus_schedule_id);
        $this->busSchedule = $bus_schedule_detail;
    }

    public function calculateTotal($bus_schedule, $ticket_amount, $voucher_id)
    {
        $voucher = Voucher::find($voucher_id);

        // get the final price percentage
        // delete the voucher
        $discount = 1;
        if ($voucher) {
            $discount = (100 - $voucher->off_percentage) / 100;

            $voucher->delete();
        }

        // get the final price in nominal
        $total = $ticket_amount * $bus_schedule->ticket_price * $discount;

        $this->total = $total;

        return $voucher;
    }

    public function processPayment(FlipTransaction $flipTransaction, array $validated)
    {
        $bus_schedule = BusSchedule::with(["bus", "originStation", "destinationStation"])
            ->findOrFail($validated["bus_schedule_id"]);
        
        $voucher = $this->calculateTotal(
            $bus_schedule,
            $validated["ticket_amount"],
            $validated["voucher"]
        );


        $flip_response = null;
        $this->status = "PENDING";
        if ($validated["payment_method"] == "cash") {
            $this->method = "cash";
            $this->status = "SUCCESSFUL";
        } else if ($validated["payment_method"] == "flip") {
            $response = $flipTransaction->createFlipBill(
                "Bus Ticket - {$bus_schedule->bus->name} - {$bus_schedule->originStation->name} - {$bus_schedule->destinationStation->name}",
                FlipBillType::SINGLE,
                $this->total,
                FlipStep::INPUT_DATA,
                "/bus/ticket"
            );

            $this->method = "flip";
            $this->flip_link_id = $response["flip_link_id"];

            $flip_response = $response;
        }

        $paymentData = [
            "flip_response" => $flip_response,
        ];

        unset($this->busSchedule);
        $this->save();

        $this->busSchedule = $bus_schedule;
        if ($voucher) {
            $this->voucher = $voucher->off_percentage . "%";
        }

        return $paymentData;
    }
}
