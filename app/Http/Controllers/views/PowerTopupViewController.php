<?php

namespace App\Http\Controllers\views;

use App\Models\Voucher;
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
            return redirect()->route("power_top_up_transaction.form");
        }
        $vouchers = Voucher::getValidVouchers("power");
        session()->reflash();

        return view("agent.power-topup.payment-method", ["vouchers" => $vouchers]);
    }

    public function showReceipt()
    {
        $transaction = session("transaction");
        $flipResponse = session("flip_response");
        if (!$transaction) {
            return redirect()->route("power_top_up_transaction.form");
        }

        return view("agent.power-topup.receipt", [
            "transaction" => $transaction,
            "flipResponse" => $flipResponse
        ]);
    }
}