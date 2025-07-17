<?php

namespace App\Http\Controllers\views;

use App\Models\BusStation;
use App\Http\Controllers\Controller;

class BusTicketViewController extends Controller {
    public function busTicket()
    {
        return view("agent.bus_ticket.bus_ticket", ["bus_stations" => BusStation::all()]);
    }

    public function busPayment()
    {
        return view("agent.bus_ticket.payment_method");
    }

    public function busReceipt()
    {
        return view("agent.bus_ticket.receipt");
    }
}