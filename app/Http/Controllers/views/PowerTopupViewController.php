<?php

namespace App\Http\Controllers\views;

use App\Http\Controllers\Controller;

class PowerTopupViewController extends Controller
{
    public function showPowerTopUpForm()
    {
        return view("agent.power_topup.form");
    }

    public function showSelectPaymentMethodPage()
    {
        if (!session()->has("transaction_attributes")) {
            return redirect("/power");
        }
        session()->reflash();

        return view("agent.power_topup.payment_method", ["vouchers" => session()->get("vouchers")]);
    }

    public function showReceipt()
    {
        $transaction = session()->get("transaction");
        if (!$transaction) {
            return redirect("/power");
        }

        return view("agent.power_topup.receipt", ["transaction" => $transaction]);
    }
}