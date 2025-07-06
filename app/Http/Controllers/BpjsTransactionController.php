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
    private function processPayment($method)
    {
        if ($method == "cash") {
            return;
        } else if ($method == "flip") {
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
        $bpjs = ActiveBpjs::where("civil_information_id", "=", $civil_information->id)->first();

        $this->processPayment($validated["payment_method"]);

        if ($bpjs->isStillActive()) {
            $bpjs->due_timestamp = $bpjs->due_timestamp + $monthBought;
            $bpjs->save();
        } else {
            $bpjs->due_timestamp = now()->unix() + $monthBought;
            $bpjs->save();
        }

        $transactionAttribute = [
            "civil_information_id" => $civil_information->id,
            "month_bought" => $validated["month"]
        ];
        $transaction = BpjsTransaction::create($transactionAttribute);

        return redirect("/bpjs/success")->with("bpjs", $bpjs)->with("form_input", $validated)->with("transaction", $transaction);
    }

    public function receipt()
    {
        $bpjs = (object) [
            "id" => 2,
            "civil_information_id" => 29,
            "due_timestamp" => 1765684716,
            "created_at" => null,
            "updated_at" => "2025-07-06T13:19:48.000000Z"
        ];
        $validated = (object) [
            "civil_id" => "33120002",
            "month" => "1",
            "payment_method" => "cash"
        ];
        $transaction = (object) [ 
            "civil_information_id" => 29,
            "month_bought" => "1",
            "updated_at" => "2025-07-06T13:35:46.000000Z",
            "created_at" => "2025-07-06T13:35:46.000000Z",
            "id" => 1
        ];

        return view("agent.bpjs_subscription.receipt", ["bpjs" => $bpjs, "form_input" => $validated, "transaction" => $transaction]);
    }
}
