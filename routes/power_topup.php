<?php

use App\Http\Controllers\utilities\PowerTransactionController;
use App\Http\Controllers\views\PowerTopupViewController;

Route::middleware("auth")->group(function () {
    Route::post("/power/payment", [PowerTransactionController::class, "prepareTransaction"]);
    Route::get("/power/payment", [PowerTopupViewController::class, "showSelectPaymentMethodPage"]);
    Route::post("/power/buy", [PowerTransactionController::class, "finalizeTransaction"]);
    Route::get("/power/receipt", [PowerTopupViewController::class, "showReceipt"]);
});