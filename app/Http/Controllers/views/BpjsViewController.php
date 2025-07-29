<?php

namespace App\Http\Controllers\views;

use App\Http\Controllers\Controller;

class BpjsViewController extends Controller
{
    public function bpjs()
    {
        $bpjs = session("bpjs");

        return view("agent.bpjs_subscription.bpjs_subscription", ["bpjs" => $bpjs]);
    }

    public function showBpjsReceipt()
    {
        $bpjs = session('bpjs');
        $form_input = session('form_input');
        $transaction = session('transaction');
        $flip_response = session("flip_response");

        session()->flash("bpjs", $bpjs);

        if (!$transaction) {
            return redirect("/bpjs")->with("bpjs", $bpjs);
        }

        return view("agent.bpjs_subscription.receipt", [
            "bpjs" => $bpjs,
            "form_input" => $form_input,
            "transaction" => $transaction,
            "flip_response" => $flip_response
        ]);
    }
}