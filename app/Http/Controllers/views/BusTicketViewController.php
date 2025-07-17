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
        $transaction_data = session()->get("transaction_data");
        $vouchers = session()->get("vouchers");

        session()->reflash();

        return view("agent.bus_ticket.payment_method", ["transaction" => $transaction_data, "vouchers" => $vouchers]);
    }

    public function busReceipt()
    {
        $transaction_data = session()->get("transaction_data");
        $payment_method = session()->get("payment_method");

        if (!$transaction_data) {
            return redirect("/bus/ticket");
        }

        return view("agent.bus_ticket.receipt", ["transaction" => $transaction_data, "payment_method" => $payment_method]);
    }
}