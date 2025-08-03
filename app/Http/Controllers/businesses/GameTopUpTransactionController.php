<?php

namespace App\Http\Controllers\businesses;

use App\Http\Requests\BuyGamePackageRequest;
use App\Http\Requests\GetGamePackagesRequest;
use App\Enums\FlipStep;
use App\Http\Requests\PayGamePackageRequest;
use App\Models\Voucher;
use App\Enums\FlipBillType;
use App\Models\GameTopUpPackage;
use App\Services\FlipTransaction;
use App\Http\Controllers\Controller;
use App\Models\GameTopUpTransaction;
use Illuminate\Support\Facades\Auth;

class GameTopUpTransactionController extends Controller
{
    public function getGamePackages(GetGamePackagesRequest $getGamePackagesRequest)
    {
        $validated = $getGamePackagesRequest->validated();
        $packages = GameTopUpPackage::with("game")->where("game_id", "=", $validated["game_id"])->get();

        return redirect("/game/topup")->with("packages", $packages)->with("selected_game_id", $validated["game_id"]);
    }

    public function buyPackage(BuyGamePackageRequest $buyGamePackageRequest, GameTopUpPackage $package)
    {
        $validated = $buyGamePackageRequest->validated();

        $transaction = [
            "user_id" => Auth::id(),
            "package_id" => $validated["game_topup_package_id"],
            "total" => $package->price
        ];

        return redirect("/game/topup/payment")->with("transaction", $transaction);
    }

    public function pay(PayGamePackageRequest $payGamePackageRequest, GameTopUpPackage $package, FlipTransaction $flipTransaction)
    {
        $validated = $payGamePackageRequest->validated();

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
        $transactionAttr["status"] = "PENDING";

        $flipResponse = null;

        if ($validated["payment_method"] == "cash") {
            $transactionAttr["status"] = "SUCCESSFUL";
        } else if ($validated["payment_method"] == "flip") {
            $response = $flipTransaction->createFlipBill(
                "Game Top Up - {$package->game->name} - {$package->title} - {$package->items_count} {$package->game->currency}",
                FlipBillType::SINGLE,
                $transactionAttr["total"],
                FlipStep::INPUT_DATA,
                "/game/topup"
            );

            $flipResponse = $response;
        }

        $transactionAttr["flip_link_id"] = $flipResponse ? $flipResponse["link_id"] : null;
        $transaction = GameTopUpTransaction::create($transactionAttr);

        if ($validated["voucher"] != -1 && $isVoucherValid) {
            $transaction->voucher = $voucher->off_percentage . "%";
        }

        return redirect("/game/topup/receipt")
            ->with("transaction", $transaction)
            ->with("flip_response", $flipResponse);
    }
}
