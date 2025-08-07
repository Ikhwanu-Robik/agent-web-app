<?php

namespace App\Http\Controllers\businesses;

use App\Models\Voucher;
use App\Models\BusSchedule;
use App\Services\FlipTransaction;
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

        $validVouchers = Voucher::getValidVouchers("bus_ticket");

        return redirect("/bus/ticket/payment")
            ->with("transaction", $transaction)
            ->with("vouchers", $validVouchers);
    }

    public function pay(PayBusTicketRequest $payBusTicketRequest, FlipTransaction $flipTransaction)
    {
        $validated = $payBusTicketRequest->validated();

        $transaction = session("transaction");
        $paymentData = $transaction->processPayment($flipTransaction, $validated);
        
        BusSchedule::find($validated["bus_schedule_id"])
            ->reduceAvailableTicket($validated["ticket_amount"]);

        return redirect("/bus/ticket/finished")
            ->with("transaction", $transaction)
            ->with("payment_method", $validated["payment_method"])
            ->with("flip_response", $paymentData["flip_response"]);
    }
}
