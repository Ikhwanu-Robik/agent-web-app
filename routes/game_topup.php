<?php

use App\Http\Controllers\utilities\GameTopUpTransactionController;

Route::middleware("auth")->group(function () {
    Route::post("/game/packages", [GameTopUpTransactionController::class, "getGamePackages"]);
});