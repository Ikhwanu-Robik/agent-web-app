<?php

namespace App\Http\Controllers\utilities;

use App\Models\Voucher;
use App\Enums\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\PowerTransaction;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\utilities\ReportController;

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

        $vouchers = Voucher::where("user_id", "=", Auth::id())->get();
        $valid_vouchers = [];
        foreach ($vouchers as $voucher) {
            $valid_services = json_decode($voucher->valid_for);

            foreach ($valid_services as $service) {
                if ($service == "power") {
                    array_push($valid_vouchers, $voucher);
                }
            }
        }

        return redirect("/power/payment")->with("transaction_attributes", $transaction_attributes)->with("vouchers", $valid_vouchers);
    }

    public function finalizeTransaction(Request $request)
    {
        $validated = $request->validate([
            "payment_method" => ["required", Rule::enum(PaymentMethod::class)],
            "voucher" => "required|numeric"
        ]);

        $voucher = Voucher::find($validated["voucher"]);
        $isVoucherValid = false;
        if ($voucher) {
            foreach (json_decode($voucher->valid_for) as $service) {
                if ($service == "power") {
                    $isVoucherValid = true;
                }
            }
        }

        $discount = 1;
        if ($validated["voucher"] != -1 && $isVoucherValid) {
            $discount = (100 - $voucher->off_percentage) / 100;

            $voucher->delete();
        }

        $transaction_attributes = session()->get("transaction_attributes");
        $transaction_attributes["total"] = $transaction_attributes["total"] * $discount;
        $transaction_attributes["method"] = $validated["payment_method"];

        if ($validated["payment_method"] == "cash") {
            $transaction_attributes["status"] = "finish";
        } else if ($validated["payment_method"] == "flip") {
            // call flip api
        }

        $transaction = PowerTransaction::create($transaction_attributes);
        if ($validated["voucher"] != -1 && $isVoucherValid) {
            $transaction->voucher = $voucher->off_percentage . "%";
        }

        ReportController::updatePowerTopUpReport();

        return redirect("/power/receipt")->with("transaction", $transaction);
    }
}
