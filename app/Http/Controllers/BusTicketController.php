<?php

namespace App\Http\Controllers;

use App\Models\BusSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\BusTicketTransaction;

class BusTicketController extends Controller
{
    public function order(Request $request)
    {
        $validated = $request->validate([
            "schedule_id" => "required|exists:bus_schedules,id",
            "ticket_amount" => "required|numeric"
        ]);

        // $bus_schedule = BusSchedule::find($validated["schedule_id"]);
        // $bus_schedule->seats = $bus_schedule->seats - $validated["ticket_amount"];

        // $transaction = BusTicketTransaction::create([
        //     "bus_schedule_id" => $validated["schedule_id"],
        //     "ticket_amount" => $validated["ticket_amount"],
        // TODO "total" => $validated["ticket_amount"] * $bus_schedule->ticket_price,
        // TODO "user_id" => Auth::id(),
        // TODO "transaction_status" => "pending",
        // ]);
        // $bus_schedule->save();

        $transaction = BusTicketTransaction::latest()->first();

        // Do I need to show the transaction receipt?
        // Yes, I need to
        $transaction_data = $transaction->with(["busSchedule.bus", "busSchedule.originStation", "busSchedule.destinationStation"])->latest()->first();
        $transaction_data->total = $transaction_data->ticket_amount * $transaction_data->busSchedule->ticket_price;
        return redirect("/transaction/payment")->with("transaction_data", $transaction_data)->with("transaction_type", "bus_ticket");
    }
}
