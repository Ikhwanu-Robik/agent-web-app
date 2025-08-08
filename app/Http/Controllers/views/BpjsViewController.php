<?php

namespace App\Http\Controllers\views;

use App\Http\Controllers\Controller;

class BpjsViewController extends Controller
{
    public function bpjs()
    {
        $bpjs = session("bpjs");

        return view("agent.bpjs-subscription.bpjs-subscription", ["bpjs" => $bpjs]);
    }

    public function showBpjsReceipt()
    {
        $bpjs = session('bpjs');
        $formInput = session('form_input');
        $transaction = session('transaction');
        $flipResponse = session("flip_response");

        session()->flash("bpjs", $bpjs);

        if (!$transaction) {
            return redirect()->route("bpjs_transaction.form")->with("bpjs", $bpjs);
        }

        return view("agent.bpjs-subscription.receipt", [
            "bpjs" => $bpjs,
            "formInput" => $formInput,
            "transaction" => $transaction,
            "flipResponse" => $flipResponse
        ]);
    }
}