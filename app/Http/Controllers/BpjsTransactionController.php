<?php

namespace App\Http\Controllers;

use App\Models\ActiveBpjs;
use App\Enums\PaymentMethod;
use App\Models\BpjsTransaction;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\CivilInformation;

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

        return redirect("/bpjs/success")->with("bpjs", $bpjs)->with("form_input", $validated)->with("transaction", $transaction);
    }

    public function receipt()
    {
        return view("agent.bpjs_subscription.receipt");
    }

    public function report(Request $request)
    {
        $validated = $request->validate([
            "civil_id" => "required|exists:civil_informations,NIK"
        ]);

        $civil_information = CivilInformation::where("NIK", "=", $validated["civil_id"])->with(["activeBpjs", "activeBpjs.bpjsClass"])->first();
        $bpjs_transactions = BpjsTransaction::where("civil_information_id", "=", $civil_information->id)
            ->get();

        // TODO : make session persists over different requests
        session()->put("bpjs_transactions", $bpjs_transactions);
        session()->put("civil_information", $civil_information);

        return view("report", ["bpjs_transactions" => $bpjs_transactions, "civil_information" => $civil_information]);
    }
}
