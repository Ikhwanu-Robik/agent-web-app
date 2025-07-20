<?php

namespace App\Http\Controllers\views;

use App\Models\Game;
use App\Http\Controllers\Controller;
use App\Models\GameTopUpPackage;

class GameTopupViewController extends Controller
{
    public function selectGame()
    {
        $packages = session()->get("packages");
        session()->reflash();

        return view("agent.game_topup.packages", [
            "games" => Game::all(),
            "packages" => $packages,
            "selected_game_id" => session("selected_game_id")
        ]);
    }

    public function gamePackage()
    {
        return view("agent.game_topup.game_topup_package");
    }

    public function selectPaymentMethod()
    {
        $transaction = session("transaction");
        $package = GameTopUpPackage::with("game")->findOr($transaction["package_id"], function () {
            return redirect("/game/topup");
        });

        if (!$transaction) {
            return redirect("/game/topup");
        }

        session()->reflash();
        
        return view("agent.game_topup.payment", ["transaction" => $transaction, "package" => $package]);
    }

    public function receipt() {
        $transaction = session("transaction");
        if (!$transaction) {
            return redirect("/game/topup");
        }
        
        $package = GameTopUpPackage::with("game")->findOr($transaction["package_id"], function () {
            return redirect("/game/topup");
        });

        return view("agent.game_topup.receipt", ["transaction" => $transaction, "package" => $package]);
    }
}