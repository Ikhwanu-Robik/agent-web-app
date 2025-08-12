<?php

namespace App\Http\Controllers\businesses;

use App\Models\BusSchedule;
use App\Http\Controllers\Controller;
use App\Models\BusTicketTransaction;
use App\Http\Requests\PayBusTicketRequest;
use App\Http\Requests\GetBusScheduleRequest;
use App\Http\Requests\OrderBusTicketRequest;

class BusTicketTransactionController extends Controller
{
    public function search(GetBusScheduleRequest $getBusScheduleRequest)
    {
        $matchingSchedules = BusSchedule::search($getBusScheduleRequest->validated());

        return back()
            ->with("matching_schedules", $matchingSchedules)
            ->with("redirect_status", "successful redirection")
            ->withInput();
    }

    public function order(OrderBusTicketRequest $orderBusTicketRequest)
    {
        $validated = $orderBusTicketRequest->validated();

        $transaction = BusTicketTransaction::createOrder($validated);
        $transaction->appendBusScheduleDetails();

        return redirect()
            ->route("bus_ticket_transaction.select_payment_method")
            ->with("transaction", $transaction);
    }

    public function pay(PayBusTicketRequest $payBusTicketRequest)
    {
        $validated = $payBusTicketRequest->validated();

        $transaction = session("transaction");
        $paymentData = $transaction->processPayment($validated);
        
        if ($transaction->status == "SUCCESSFUL") {
            BusSchedule::find($validated["bus_schedule_id"])
                ->reduceAvailableTicket($validated["ticket_amount"]);
        }

        return redirect()
            ->route("bus_ticket_transaction.receipt")
            ->with("transaction", value: $transaction)
            ->with("payment_method", $validated["payment_method"])
            ->with("flip_response", $paymentData["flip_response"]);
    }
}
