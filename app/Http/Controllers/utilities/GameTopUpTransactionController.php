<?php

namespace App\Http\Controllers\utilities;

use App\Models\Game;
use App\Models\GameTopUpPackage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GameTopUpTransactionController extends Controller
{
    public function getGamePackages(Request $request) {
        $validated = $request->validate([
            "game_id" => "required|exists:games,id"
        ]);
        $packages = GameTopUpPackage::with("game")->where("game_id", "=", $validated["game_id"])->get();

        return redirect("/game/topup")->with("packages", $packages);
    }
}
