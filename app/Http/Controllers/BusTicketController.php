<?php

namespace App\Http\Controllers;

use App\Enums\PaymentMethod;
use App\Models\BusSchedule;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\BusTicketTransaction;
use App\Models\Voucher;
use Illuminate\Support\Facades\Auth;

class BusTicketController extends Controller
{
    public function order(Request $request)
    {
        $validated = $request->validate([
            "schedule_id" => "required|exists:bus_schedules,id",
            "ticket_amount" => "required|numeric"
        ]);

        $bus_schedule = BusSchedule::find($validated["schedule_id"]);

        $attribute = [
            "user_id" => Auth::id(),
            "bus_schedule_id" => $validated["schedule_id"],
            "ticket_amount" => $validated["ticket_amount"],
            "total" => $validated["ticket_amount"] * $bus_schedule->ticket_price,
            "status" => "pending",
        ];
        $transaction = BusTicketTransaction::make($attribute);
        $bus_schedule_detail = BusSchedule::with(["bus", "originStation", "destinationStation"])->findOrFail($attribute["bus_schedule_id"]);
        $transaction->busSchedule = $bus_schedule_detail;

        $vouchers = Voucher::where("user_id", "=", Auth::id())->get();
        $valid_vouchers = [];
        foreach ($vouchers as $voucher) {
            $valid_services = json_decode($voucher->valid_for);

            foreach ($valid_services as $service) {
                if ($service == "bus_ticket") {
                    array_push($valid_vouchers, $voucher);
                }
            }
        }
        return redirect("/bus/ticket/payment")->with("transaction_data", $transaction)->with("vouchers", $valid_vouchers);
    }

    public function payment()
    {
        return view("agent.bus_ticket.payment_method");
    }

    public function receipt()
    {
        return view("agent.bus_ticket.receipt");
    }

    public function pay(Request $request)
    {
        $validated = $request->validate([
            "bus_schedule_id" => "required|exists:bus_schedules,id",
            "ticket_amount" => "required|numeric",
            "payment_method" => ["required", Rule::enum(PaymentMethod::class)],
            "voucher" => "required"
        ]);

        $voucher = Voucher::find($validated["voucher"]);
        $isVoucherValid = false;
        if ($voucher) {
            foreach (json_decode($voucher->valid_for) as $service) {
                if ($service == "bus_ticket") {
                    $isVoucherValid = true;
                }
            }
        }

        $discount = 1;
        if ($validated["voucher"] != -1 && $isVoucherValid) {
            $discount = (100 - $voucher->off_percentage) / 100;

            $voucher->delete();
        }

        $payment_method = null;
        $status = "pending";
        if ($validated["payment_method"] == "cash") {
            $payment_method = "cash";
            $status = "finished";
        } else if ($validated["payment_method" == "flip"]) {
            // call flip api
        }

        $bus_schedule = BusSchedule::with(["bus", "originStation", "destinationStation"])->findOrFail($validated["bus_schedule_id"]);
        $total = $validated["ticket_amount"] * $bus_schedule->ticket_price * $discount;
        $bus_schedule->seats = $bus_schedule->seats - $validated["ticket_amount"];
        $bus_schedule->save();

        $attributes = [
            "user_id" => Auth::id(),
            "bus_schedule_id" => $validated["bus_schedule_id"],
            "ticket_amount" => $validated["ticket_amount"],
            "method" => $payment_method,
            "total" => $total,
            "status" => $status
        ];

        $transaction = BusTicketTransaction::create($attributes);
        $transaction->busSchedule = $bus_schedule;

        return redirect("/bus/ticket/finished")->with("transaction_data", $transaction)->with("payment_method", $validated["payment_method"]);
    }
}
