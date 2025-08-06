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
        $package = GameTopUpPackage::with("game")->findOr($transaction->package_id, function () {
            return redirect("/game/topup");
        });

        if (!$transaction) {
            return redirect("/game/topup");
        }

        $vouchers = Voucher::where("user_id", "=", Auth::id())->get();
        $valid_vouchers = [];
        foreach ($vouchers as $voucher) {
            $valid_services = json_decode($voucher->valid_for);

            foreach ($valid_services as $service) {
                if ($service == "game_top_up") {
                    array_push($valid_vouchers, $voucher);
                }
            }
        }

        session()->reflash();

        return view("agent.game_topup.payment", [
            "transaction" => $transaction,
            "package" => $package,
            "vouchers" => $valid_vouchers
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

        return view("agent.game_topup.receipt", [
            "transaction" => $transaction,
            "package" => $package,
            "flipResponse" => $flipResponse
        ]);
    }
}