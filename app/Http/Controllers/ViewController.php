<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ViewController extends Controller
{
    public function home() {
        return view("home");
    }

    public function busTicket() {
        return view("bus_ticket");
    }

    public function bpjs() {
        return view("bpjs_subscription");
    }
}
