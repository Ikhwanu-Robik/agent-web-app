<?php

namespace App\Http\Controllers\utilities;

use Carbon\Carbon;
use App\Models\Voucher;
use App\Enums\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\GameTopUpPackage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\GameTopUpTransaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class GameTopUpTransactionController extends Controller
{
    public function getGamePackages(Request $request)
    {
        $validated = $request->validate([
            "game_id" => "required|exists:games,id"
        ]);
        $packages = GameTopUpPackage::with("game")->where("game_id", "=", $validated["game_id"])->get();

        return redirect("/game/topup")->with("packages", $packages)->with("selected_game_id", $validated["game_id"]);
    }

    public function buyPackage(Request $request, GameTopUpPackage $package)
    {
        $validator = Validator::make($request->all(), [
            "game_id" => "required|exists:games,id",
            "game_topup_package_id" => "required|exists:game_topup_packages,id"
        ]);

        $validated = $validator->validated();
        $package = GameTopUpPackage::find($validated["game_topup_package_id"]);

        $validator->after(function ($validator, $validated, $package) {
            if ($package->game_id != $validated["game_id"]) {
                $validator->errors()->add("game_topup_package_id", "game topup package id must belong to the given game");
            }
        });

        $transaction = [
            "user_id" => Auth::id(),
            "package_id" => $validated["game_topup_package_id"],
            "total" => $package->price
        ];

        return redirect("/game/topup/payment")->with("transaction", $transaction);
    }

    public function pay(Request $request, GameTopUpPackage $package)
    {
        $validated = $request->validate([
            "payment_method" => ["required", Rule::enum(PaymentMethod::class)],
            "voucher" => "required"
        ]);

        $voucher = Voucher::find($validated["voucher"]);
        $isVoucherValid = false;
        if ($voucher) {
            foreach (json_decode($voucher->valid_for) as $service) {
                if ($service == "game_top_up") {
                    $isVoucherValid = true;
                }
            }
        }

        $discount = 1;
        if ($validated["voucher"] != -1 && $isVoucherValid) {
            $discount = (100 - $voucher->off_percentage) / 100;

            $voucher->delete();
        }

        $transactionAttr = session()->get("transaction");
        $transactionAttr["total"] = $transactionAttr["total"] * $discount;
        $transactionAttr["method"] = $validated["payment_method"];

        if ($validated["payment_method"] == "cash") {
            $transactionAttr["status"] = "finish";
        } else if ($validated["payment_method"] == "flip") {
            // call flip api
        }

        $transaction = GameTopUpTransaction::create($transactionAttr);
        if ($validated["voucher"] != -1 && $isVoucherValid) {
            $transaction->voucher = $voucher->off_percentage . "%";
        }

        return redirect("/game/topup/receipt")
            ->with("transaction", $transaction);
    }
}
