<?php

use App\Http\Controllers\businesses\PowerTopUpTransactionController;
use App\Http\Controllers\businesses\ReportController;
use App\Http\Controllers\views\PowerTopupViewController;

Route::middleware("auth")->group(function () {
    Route::get("/power", [PowerTopupViewController::class, "showPowerTopUpForm"])
        ->name("power_top_up_transaction.form");
    Route::post("/power", [PowerTopUpTransactionController::class, "order"])
        ->name("power_top_up_transaction.order");
    Route::get("/power/payment", [PowerTopupViewController::class, "showSelectPaymentMethodPage"])
        ->name("power_top_up_transaction.select_payment_method");
    Route::post("/power/pay", [PowerTopUpTransactionController::class, "pay"])
        ->name("power_top_up_transaction.pay");
    Route::get("/power/receipt", [PowerTopupViewController::class, "showReceipt"])
        ->name("power_top_up_transaction.receipt");

    Route::post("/report/power", [ReportController::class, "getPowerTopUpReport"])
        ->name("report.find_power");
});