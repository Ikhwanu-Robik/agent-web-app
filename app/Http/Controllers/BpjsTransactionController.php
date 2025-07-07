<?php

namespace App\Http\Controllers;

use App\Models\ActiveBpjs;
use App\Enums\PaymentMethod;
use App\Models\BpjsTransaction;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\CivilInformation;
use Illuminate\Support\Facades\Log;

class BpjsTransactionController extends Controller
{
    private function processPayment($transaction)
    {
        $price = 30000;
        if ($transaction["payment_method"] == "cash") {
            $total = $transaction["month"] * $price;
            return $total;
        } else if ($transaction["payment_method"] == "flip") {
            // TODO : call flip api
        }

        return response("Payment method invalid", 422);
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
        $bpjs = ActiveBpjs::where("civil_information_id", "=", $civil_information->id)->first();

        $total = $this->processPayment($validated);

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

        return redirect("/bpjs/success")->with("bpjs", $bpjs)->with("form_input", $validated)->with("transaction", $transaction);
    }

    public function receipt()
    {
        return view("agent.bpjs_subscription.receipt");
    }
}
