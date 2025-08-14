<?php

namespace App\Http\Controllers\businesses;

use App\Models\Game;
use App\Models\GameTopUpPackage;
use App\Http\Controllers\Controller;
use App\Models\GameTopUpTransaction;
use App\Http\Requests\PayGamePackageRequest;
use App\Http\Requests\GetGamePackagesRequest;
use App\Http\Requests\OrderGamePackageRequest;

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

    public function order(OrderGamePackageRequest $orderGamePackageRequest, Game $game, GameTopUpPackage $package)
    {
        $validated = $orderGamePackageRequest->validated();

        $transaction = GameTopUpTransaction::createOrder($validated, $package);

        return redirect()
            ->route("game_top_up_transaction.select_payment_method", [
                "game" => $game->id,
                "package" => $package->id
            ])
            ->with("transaction", $transaction);
    }

    public function pay(PayGamePackageRequest $payGamePackageRequest, Game $game, GameTopUpPackage $package)
    {
        $validated = $payGamePackageRequest->validated();

        $transaction = session("transaction");

        $flipResponse = $transaction->processPayment($package, $validated);

        return redirect()
            ->route("game_top_up_transaction.receipt", [
                "game" => $game->id,
                "package" => $package->id
            ])
            ->with("transaction", $transaction)
            ->with("flip_response", $flipResponse);
    }
}
