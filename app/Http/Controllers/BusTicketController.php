<?php

namespace App\Http\Controllers;

use App\Enums\PaymentMethod;
use App\Models\BusSchedule;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
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

        $attribute = [
            "user_id" => Auth::id(),
            "bus_schedule_id" => $validated["schedule_id"],
            "ticket_amount" => $validated["ticket_amount"],
            "total" => $validated["ticket_amount"] * $bus_schedule->ticket_price,
            "status" => "pending",
        ];
        $transaction = BusTicketTransaction::create($attribute);
        $transaction_data = BusTicketTransaction::with(["busSchedule.bus", "busSchedule.originStation", "busSchedule.destinationStation"])->find($transaction->id);

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
        $validated = $request->validate([
            "payment_method" => ["required", Rule::enum(PaymentMethod::class)],
            "bus_ticket_transaction_id" => "required|exists:bus_ticket_transactions,id"
        ]);

        $transaction_data = BusTicketTransaction::with(["busSchedule.bus", "busSchedule.originStation", "busSchedule.destinationStation"])->find($validated["bus_ticket_transaction_id"]);

        if ($validated["payment_method"] == "cash") {
            $bus_schedule = $transaction_data->busSchedule;
            $bus_schedule->seats = $bus_schedule->seats - $transaction_data->ticket_amount;
            $bus_schedule->save();
            
            $transaction_data->status = "finished";
            $transaction_data->method = "cash";
            $transaction_data->save();
        } else if ($validated["payment_method" == "flip"]) {
            // call flip api
        }
        
        return redirect("/bus/ticket/finished")->with("transaction_data", $transaction_data)->with("payment_method", $validated["payment_method"]);
    }
}
