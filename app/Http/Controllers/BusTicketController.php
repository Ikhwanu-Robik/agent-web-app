<?php

namespace App\Http\Controllers;

use App\Models\BusSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\BusTicketTransaction;
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
        $bus_schedule->seats = $bus_schedule->seats - $validated["ticket_amount"];

        $attribute = [
            "user_id" => Auth::id(),
            "bus_schedule_id" => $validated["schedule_id"],
            "ticket_amount" => $validated["ticket_amount"],
            "total" => $validated["ticket_amount"] * $bus_schedule->ticket_price,
            "status" => "pending",
        ];
        $transaction = BusTicketTransaction::create($attribute);
        $transaction_data = BusTicketTransaction::with(["busSchedule.bus", "busSchedule.originStation", "busSchedule.destinationStation"])->find($transaction->id);

        $bus_schedule->save();

        return redirect("/bus/ticket/payment")->with("transaction_data", $transaction_data);
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
        // process according to payment method

        $transaction = BusTicketTransaction::latest()->first(); // tmp

        $transaction_data = $transaction->with(["busSchedule.bus", "busSchedule.originStation", "busSchedule.destinationStation"])->latest()->first();
        $transaction_data->total = $transaction_data->ticket_amount * $transaction_data->busSchedule->ticket_price; // tmp
        return redirect("/bus/ticket/finished")->with("transaction_data", $transaction_data);
    }
}
