<?php

namespace App\Models;

use App\Enums\FlipStep;
use App\Models\ActiveBpjs;
use App\Enums\FlipBillType;
use App\Models\CivilInformation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Facades\App\Services\FlipTransaction;

class BpjsTransaction extends Model
{
    protected $table = "bpjs_transactions";

    protected $fillable = [
        "user_id",
        "civil_information_id",
        "month_bought",
        "total",
        "method",
        "status",
        "flip_link_id"
    ];

    public function civilInformation()
    {
        return $this->belongsTo(CivilInformation::class, "civil_information_id", "id");
    }

    public static function pay(array $validated)
    {
        $monthBought = $validated["month"] * 30 * 24 * 60 * 60;

        $civil_information = CivilInformation::where("NIK", "=", $validated["civil_id"])->first();
        $bpjs = ActiveBpjs::search($civil_information->NIK);

        $price = $bpjs->bpjsClass->price;
        $total = $validated["month"] * $price;
        $status = "PENDING";
        $flip_response = null;
        if ($validated["payment_method"] == "cash") {
            $status = "SUCCESS";
        } else if ($validated["payment_method"] == "flip") {
            $response = FlipTransaction::createFlipBill(
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
        $transaction = self::create($transactionAttribute);
        $transaction["flip_response"] = $flip_response;

        return $transaction;
    }
}
