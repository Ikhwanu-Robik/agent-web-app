<?php

namespace App\Http\Controllers\utilities;

use App\Enums\FlipBillType;
use App\Enums\FlipStep;
use App\Models\ActiveBpjs;
use App\Enums\PaymentMethod;
use App\Services\FlipTransaction;
use Illuminate\Http\Request;
use App\Models\BpjsTransaction;
use Illuminate\Validation\Rule;
use App\Models\CivilInformation;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\utilities\ReportController;

class BpjsTransactionController extends Controller
{
    public function pay(Request $request, FlipTransaction $flipTransaction)
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

        $price = $bpjs->bpjsClass->price;
        $total = $validated["month"] * $price;
        $status = "PENDING";
        $flip_response = null;
        if ($validated["payment_method"] == "cash") {
            $status = "SUCCESS";
        } else if ($validated["payment_method"] == "flip") {
            $response = $flipTransaction->createFlipBill(
                "BPJS - {$monthBought} months",
                FlipBillType::SINGLE,
                $total,
                FlipStep::INPUT_DATA,
                "/bpjs"
            );

            $flip_response = $response;
        }

        if ($bpjs->isStillActive()) {
            $bpjs->due_timestamp = $bpjs->due_timestamp + $monthBought;
            $bpjs->save();
        } else {
            $bpjs->due_timestamp = now()->unix() + $monthBought;
            $bpjs->save();
        }

        $transactionAttribute = [
            "user_id" => Auth::id(),
            "civil_information_id" => $civil_information->id,
            "month_bought" => $validated["month"],
            "total" => $total,
            "method" => $validated["payment_method"],
            "status" => $status,
            "flip_link_id" => $flip_response ? $flip_response["link_id"] : null
        ];
        $transaction = BpjsTransaction::create($transactionAttribute);

        ReportController::updateBpjsReport();

        return redirect("/bpjs/receipt")
            ->with("bpjs", $bpjs)
            ->with("form_input", $validated)
            ->with("transaction", $transaction)
            ->with("flip_response", $flip_response);
    }
}
