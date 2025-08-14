<?php

namespace App\Http\Controllers\views;

use App\Models\BusSchedule;
use App\Models\Voucher;
use App\Models\BusStation;
use App\Http\Controllers\Controller;

class BusTicketViewController extends Controller
{
    public function showSearchBusScheduleForm()
    {
        return view("agent.bus-ticket.bus-ticket", ["busStations" => BusStation::all()]);
    }

    public function showPaymentForm(BusSchedule $schedule)
    {
        $transaction = session("transaction");
        $vouchers = Voucher::getValidVouchers("bus_ticket");

        session()->reflash();

        return view("agent.bus-ticket.payment-method", [
            "transaction" => $transaction,
            "vouchers" => $vouchers
        ]);
    }

    public function showReceipt(BusSchedule $schedule)
    {
        $transaction = session("transaction");
        $paymentMethod = session("payment_method");
        $flipResponse = session("flip_response");

        if (!$transaction) {
            return redirect()->route("bus_ticket_transaction.select_schedule");
        }

        return view("agent.bus-ticket.receipt", [
            "transaction" => $transaction,
            "paymentMethod" => $paymentMethod,
            "flipResponse" => $flipResponse
        ]);
    }
}