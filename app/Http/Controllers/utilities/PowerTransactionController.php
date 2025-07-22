<?php

namespace App\Http\Controllers\utilities;

use App\Enums\PaymentMethod;
use App\Models\PowerTransaction;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;

class PowerTransactionController extends Controller
{
    public function prepareTransaction(Request $request)
    {
        $validated = $request->validate([
            "subscriber_number" => "required|numeric",
            "nominal" => "required|numeric"
        ]);

        // pretend calling external api to validate subscriber_number
        // POST https://pln.co.id/api/subcibers/validate
        // { "subscriber_number": $validated["subscriber_number"] }

        $transaction_attributes = [
            "subscriber_number" => $validated["subscriber_number"],
            "total" => $validated["nominal"],
            "method" => null,
            "status" => null
        ];

        return redirect("/power/payment")->with("transaction_attributes", $transaction_attributes);
    }

    public function finalizeTransaction(Request $request)
    {
        $validated = $request->validate([
            "payment_method" => ["required", Rule::enum(PaymentMethod::class)]
        ]);

        $transaction_attributes = session()->get("transaction_attributes");
        $transaction_attributes["method"] = $validated["payment_method"];

        if ($validated["payment_method"] == "cash") {
            $transaction_attributes["status"] = "finish";
        } else if ($validated["payment_method"] == "flip") {
            // call flip api
        }

        $transaction = PowerTransaction::create($transaction_attributes);

        return redirect("/power/receipt")->with("transaction", $transaction);
    }
}
