<?php

use App\Http\Controllers\businesses\GameTopUpTransactionController;
use App\Http\Controllers\views\GameTopupViewController;

Route::middleware("auth")->group(function () {
    Route::get("/games", [GameTopupViewController::class, "showSelectGameForm"])
        ->name("game_top_up_transaction.select_game");
    Route::post("/games/{game}/packages", [GameTopUpTransactionController::class, "getGamePackages"])
        ->name("game_top_up_transaction.find_game_packages");
    Route::post("/games/{game}/packages/{package}", [GameTopUpTransactionController::class, "order"])
        ->name("game_top_up_transaction.order_package");
    Route::get("/games/{game}/packages/{package}/payment", [GameTopupViewController::class, "selectPayment"])
        ->name("game_top_up_transaction.select_payment_method");
    Route::post("/games/{game}/packages/{package}/pay", [GameTopUpTransactionController::class, "pay"])
        ->name("game_top_up_transaction.pay");
    Route::get("/games/{game}/packages/{package}/receipt", [GameTopupViewController::class, "showReceipt"])
        ->name("game_top_up_transaction.receipt");
});