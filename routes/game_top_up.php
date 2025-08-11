<?php

use App\Http\Controllers\businesses\GameTopUpTransactionController;
use App\Http\Controllers\views\GameTopupViewController;

Route::middleware("auth")->group(function () {
    Route::post("/game/packages", [GameTopUpTransactionController::class, "getGamePackages"])
        ->name("game_top_up_transaction.find_game_packages");
    Route::post("/game/package/{package}", [GameTopUpTransactionController::class, "order"])
        ->name("game_top_up_transaction.order_package");
    Route::get("/game/top-up/payment", [GameTopupViewController::class, "selectPaymentMethod"])
        ->name("game_top_up_transaction.select_payment_method");
    Route::post("/game/top-up/package/{package}/pay", [GameTopUpTransactionController::class, "pay"])
        ->name("game_top_up_transaction.pay");
    Route::get("/game/top-up/receipt", [GameTopupViewController::class, "receipt"])
        ->name("game_top_up_transaction.receipt");
});