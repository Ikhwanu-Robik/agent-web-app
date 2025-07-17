<?php

namespace App\Http\Controllers\views;

use App\Http\Controllers\Controller;

class PowerTopupViewController extends Controller
{
    public function power()
    {
        return view("agent.electric_token.electric_token");
    }
}