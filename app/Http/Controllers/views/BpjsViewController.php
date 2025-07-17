<?php

namespace App\Http\Controllers\views;

use App\Http\Controllers\Controller;

class BpjsViewController extends Controller {
    public function bpjs()
    {
        return view("agent.bpjs_subscription.bpjs_subscription");
    }

    public function showBpjsReceipt()
    {
        return view("agent.bpjs_subscription.receipt");
    }
}