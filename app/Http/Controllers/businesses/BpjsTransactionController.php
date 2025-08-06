<?php

namespace App\Http\Controllers\businesses;

use App\Facades\TransactionReport;
use App\Models\ActiveBpjs;
use App\Services\FlipTransaction;
use App\Models\BpjsTransaction;
use App\Models\CivilInformation;
use App\Http\Controllers\Controller;
use App\Http\Requests\GetBpjsDataRequest;
use App\Http\Requests\PayBpjsTransactionRequest;

class BpjsTransactionController extends Controller
{
    public function search(GetBpjsDataRequest $getBpjsDataRequest)
    {
        $bpjs = ActiveBpjs::search($getBpjsDataRequest->validated()["civil_id"]);

        return redirect("/bpjs")->with("bpjs", $bpjs);
    }

    public function pay(PayBpjsTransactionRequest $payBpjsTransactionRequest, FlipTransaction $flipTransaction)
    {
        $validated = $payBpjsTransactionRequest->validated();

        $civil_information = CivilInformation::where("NIK", "=", $validated["civil_id"])->first();
        $bpjs = ActiveBpjs::search($civil_information->NIK);

        $transaction = BpjsTransaction::pay($payBpjsTransactionRequest->validated());

        TransactionReport::updateBpjsReport();

        return redirect("/bpjs/receipt")
            ->with("bpjs", $bpjs)
            ->with("form_input", $validated)
            ->with("transaction", $transaction)
            ->with("flip_response", $transaction["flip_response"]);
    }
}
