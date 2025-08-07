<?php

namespace App\Http\Controllers\views;

use App\Models\Game;
use App\Models\Voucher;
use App\Models\GameTopUpPackage;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class GameTopupViewController extends Controller
{
    public function selectGame()
    {
        $packages = session("packages");
        session()->reflash();

        return view("agent.game-topup.packages", [
            "games" => Game::all(),
            "packages" => $packages,
            "selectedGameId" => session("selected_game_id")
        ]);
    }

    public function gamePackage()
    {
        return view("agent.game-topup.game-topup-package");
    }

    public function selectPaymentMethod()
    {
        $transaction = session("transaction");
        $package = GameTopUpPackage::with("game")
            ->findOr($transaction->package_id, function () {
                return redirect("/game/topup");
            });

        if (!$transaction) {
            return redirect("/game/topup");
        }

        $validVouchers = Voucher::getValidVouchers("game_top_up");

        session()->reflash();

        return view("agent.game-topup.payment", [
            "transaction" => $transaction,
            "package" => $package,
            "vouchers" => $validVouchers
        ]);
    }

    public function receipt()
    {
        $transaction = session("transaction");
        $flipResponse = session("flip_response");
        if (!$transaction) {
            return redirect("/game/topup");
        }

        $package = GameTopUpPackage::with("game")
            ->findOr($transaction["package_id"], function () {
                return redirect("/game/topup");
            });

        return view("agent.game-topup.receipt", [
            "transaction" => $transaction,
            "package" => $package,
            "flipResponse" => $flipResponse
        ]);
    }
}