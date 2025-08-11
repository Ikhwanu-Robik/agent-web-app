<?php

namespace App\Http\Controllers\businesses;

use App\Facades\TransactionReport;
use App\Http\Requests\FinalizePowerTopUpRequest;
use App\Http\Requests\PreparePowerTopUpRequest;
use App\Models\PowerTransaction;
use App\Http\Controllers\Controller;

class PowerTopUpTransactionController extends Controller
{
    public function prepareTransaction(PreparePowerTopUpRequest $preparePowerTopUpRequest)
    {
        $validated = $preparePowerTopUpRequest->validated();

        // pretend calling external api to validate subscriber_number
        // POST https://pln.co.id/api/subcibers/validate
        // { "subscriber_number": $validated["subscriber_number"] }

        $transaction = PowerTransaction::createOrder($validated);

        return redirect()
            ->route("power_top_up_transaction.select_payment_method")
            ->with("transaction", $transaction);
    }

    public function finalizeTransaction(FinalizePowerTopUpRequest $finalizePowerTopUpRequest)
    {
        $validated = $finalizePowerTopUpRequest->validated();

        $transaction = session("transaction");

        $paymentData = $transaction->processPayment($validated);

        TransactionReport::updatePowerTopUpReport();

        return redirect()
            ->route("power_top_up_transaction.receipt")
            ->with("transaction", $transaction)
            ->with("flip_response", $paymentData["flipResponse"]);
    }
}
