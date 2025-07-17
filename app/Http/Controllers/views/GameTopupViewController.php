<?php

namespace App\Http\Controllers\views;

use App\Http\Controllers\Controller;

class GameTopupViewController extends Controller {
    public function game()
    {
        return view("agent.game_topup.game_topup");
    }

    public function gamePackage()
    {
        $game = null;
        // fetch the selected game model

        if (!$game) {
            return response("You need to choose a game to view this page");
        }

        return view("agent.game_topup.game_topup_package");
    }
}