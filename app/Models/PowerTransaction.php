<?php

namespace App\Models;

use App\Enums\FlipStep;
use App\Models\Voucher;
use App\Enums\FlipBillType;
use App\Services\FlipTransaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class PowerTransaction extends Model
{
    protected $fillable = [
        "user_id",
        "subscriber_number",
        "total",
        "method",
        "status",
        "flip_link_id"
    ];

    public static function createOrder(array $validated)
    {
        $transaction = self::make([
            "user_id" => Auth::id(),
            "subscriber_number" => $validated["subscriber_number"],
            "total" => $validated["nominal"],
            "method" => null,
            "status" => null,
            "flip_link_id" => null
        ]);

        return $transaction;
    }

    public function calculateTotal($voucher_id)
    {
        $voucher = Voucher::find($voucher_id);
        $discount = 1;
        if ($voucher) {
            $discount = (100 - $voucher->off_percentage) / 100;

            $voucher->delete();
        }
        $this->total = $this->total * $discount;

        return $voucher;
    }

    public function processPayment(FlipTransaction $flipTransaction, array $validated)
    {
        $voucher = $this->calculateTotal($validated["voucher"]);

        $this->method = $validated["payment_method"];
        $this->status = "PENDING";

        $flipResponse = null;
        if ($validated["payment_method"] == "cash") {
            $this->status = "SUCCESSFUL";
        } else if ($validated["payment_method"] == "flip") {
            $response = $flipTransaction->createFlipBill(
                "Power Top Up",
                FlipBillType::SINGLE,
                $this->total,
                FlipStep::INPUT_DATA,
                "/power"
            );

            $flipResponse = $response;
        }

        $transaction_attributes["flip_link_id"] = $flipResponse ? $flipResponse["link_id"] : null;

        self::save();

        $paymentData = [
            "flipResponse" => $flipResponse
        ];

        // appending extra data for receipt
        if ($voucher) {
            $this->voucher = $voucher->off_percentage . "%";
        }

        return $paymentData;
    }
}