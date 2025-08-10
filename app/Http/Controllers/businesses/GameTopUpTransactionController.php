<?php

namespace App\Http\Controllers\businesses;

use App\Http\Requests\BuyGamePackageRequest;
use App\Http\Requests\GetGamePackagesRequest;
use App\Http\Requests\PayGamePackageRequest;
use App\Models\GameTopUpPackage;
use App\Http\Controllers\Controller;
use App\Models\GameTopUpTransaction;

class GameTopUpTransactionController extends Controller
{
    public function getGamePackages(GetGamePackagesRequest $getGamePackagesRequest)
    {
        $validated = $getGamePackagesRequest->validated();
        $packages = GameTopUpPackage::with("game")
            ->where("game_id", "=", $validated["game_id"])
            ->get();

        return redirect()
            ->route("game_top_up_transaction.select_game")
            ->with("packages", $packages)
            ->with("selected_game_id", $validated["game_id"]);
    }

    public function buyPackage(BuyGamePackageRequest $buyGamePackageRequest, GameTopUpPackage $package)
    {
        $validated = $buyGamePackageRequest->validated();

        $transaction = GameTopUpTransaction::createOrder($validated, $package);

        return redirect()
            ->route("game_top_up_transaction.select_payment_method")
            ->with("transaction", $transaction);
    }

    public function pay(PayGamePackageRequest $payGamePackageRequest, GameTopUpPackage $package)
    {
        $validated = $payGamePackageRequest->validated();

        $transaction = session("transaction");

        $flipResponse = $transaction->processPayment($package, $validated);

        return redirect()
            ->route("game_top_up_transaction.receipt")
            ->with("transaction", $transaction)
            ->with("flip_response", $flipResponse);
    }
}
