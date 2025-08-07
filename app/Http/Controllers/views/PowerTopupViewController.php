<?php

namespace App\Http\Controllers\views;

use App\Http\Controllers\Controller;

class PowerTopupViewController extends Controller
{
    public function showPowerTopUpForm()
    {
        return view("agent.power-topup.form");
    }

    public function showSelectPaymentMethodPage()
    {
        if (!session()->has("transaction")) {
            return redirect("/power");
        }
        session()->reflash();

        return view("agent.power-topup.payment-method", ["vouchers" => session("vouchers")]);
    }

    public function showReceipt()
    {
        $transaction = session("transaction");
        $flipResponse = session("flip_response");
        if (!$transaction) {
            return redirect("/power");
        }

        return view("agent.power-topup.receipt", [
            "transaction" => $transaction,
            "flipResponse" => $flipResponse
        ]);
    }
}