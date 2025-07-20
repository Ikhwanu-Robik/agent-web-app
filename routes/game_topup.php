<?php

use App\Http\Controllers\utilities\GameTopUpTransactionController;
use App\Http\Controllers\views\GameTopupViewController;

Route::middleware("auth")->group(function () {
    Route::post("/game/packages", [GameTopUpTransactionController::class, "getGamePackages"]);
    Route::post("/game/package/{package}", [GameTopUpTransactionController::class, "buyPackage"]);
    Route::get("/game/topup/payment", [GameTopupViewController::class, "selectPaymentMethod"]);
    Route::post("/game/topup/package/{package}/pay", [GameTopUpTransactionController::class, "pay"]);
    Route::get("/game/topup/receipt", [GameTopupViewController::class, "receipt"]);
});