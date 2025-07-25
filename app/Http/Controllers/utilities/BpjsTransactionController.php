<?php

namespace App\Http\Controllers\utilities;

use App\Models\ActiveBpjs;
use App\Enums\PaymentMethod;
use Illuminate\Http\Request;
use App\Models\BpjsTransaction;
use Illuminate\Validation\Rule;
use App\Models\CivilInformation;
use App\Http\Controllers\Controller;

class BpjsTransactionController extends Controller
{
    private function processPayment($transaction, $bpjs)
    {
        $price = $bpjs->bpjsClass->price;
        if ($transaction["payment_method"] == "cash") {
            $total = $transaction["month"] * $price;
            return $total;
        } else if ($transaction["payment_method"] == "flip") {
            // TODO : call flip api
        }
    }

    public function pay(Request $request)
    {
        $validated = $request->validate([
            "civil_id" => "required|exists:civil_informations,NIK",
            "month" => "required|numeric|min:1",
            "payment_method" => [
                "required",
                Rule::enum(PaymentMethod::class)
            ]
        ]);

        $monthBought = $validated["month"] * 30 * 24 * 60 * 60;

        $civil_information = CivilInformation::where("NIK", "=", $validated["civil_id"])->with("activeBpjs")->first();
        $bpjs = ActiveBpjs::with("bpjsClass")->where("civil_information_id", "=", $civil_information->id)->first();

        $total = $this->processPayment($validated, $bpjs);

        if ($bpjs->isStillActive()) {
            $bpjs->due_timestamp = $bpjs->due_timestamp + $monthBought;
            $bpjs->save();
        } else {
            $bpjs->due_timestamp = now()->unix() + $monthBought;
            $bpjs->save();
        }

        $transactionAttribute = [
            "civil_information_id" => $civil_information->id,
            "month_bought" => $validated["month"],
            "total" => $total,
            "method" => $validated["payment_method"]
        ];
        $transaction = BpjsTransaction::create($transactionAttribute);

        ReportController::updateBpjsReport();

        return redirect("/bpjs/receipt")->with("bpjs", $bpjs)->with("form_input", $validated)->with("transaction", $transaction);
    }
}
