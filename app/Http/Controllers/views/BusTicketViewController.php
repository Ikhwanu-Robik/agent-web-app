<?php

namespace App\Http\Controllers\views;

use App\Models\BusStation;
use App\Http\Controllers\Controller;

class BusTicketViewController extends Controller
{
    public function busTicket()
    {
        return view("agent.bus_ticket.bus_ticket", ["bus_stations" => BusStation::all()]);
    }

    public function busPayment()
    {
        $transaction = session()->get("transaction");
        $vouchers = session()->get("vouchers");

        session()->reflash();

        return view("agent.bus_ticket.payment_method", [
            "transaction" => $transaction,
            "vouchers" => $vouchers
        ]);
    }

    public function busReceipt()
    {
        $transaction = session("transaction");
        $payment_method = session("payment_method");
        $flip_response = session("flip_response");

        if (!$transaction) {
            return redirect("/bus/ticket");
        }

        return view("agent.bus_ticket.receipt", [
            "transaction" => $transaction,
            "payment_method" => $payment_method,
            "flip_response" => $flip_response
        ]);
    }
}