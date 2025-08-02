<?php

use App\Http\Controllers\businesses\PowerTopUpTransactionController;
use App\Http\Controllers\businesses\ReportController;
use App\Http\Controllers\views\PowerTopupViewController;

Route::middleware("auth")->group(function () {
    Route::post("/power/payment", [PowerTopUpTransactionController::class, "prepareTransaction"]);
    Route::get("/power/payment", [PowerTopupViewController::class, "showSelectPaymentMethodPage"]);
    Route::post("/power/buy", [PowerTopUpTransactionController::class, "finalizeTransaction"]);
    Route::get("/power/receipt", [PowerTopupViewController::class, "showReceipt"]);

    Route::post("/report/power", [ReportController::class, "getPowerTopUpReport"]);
});