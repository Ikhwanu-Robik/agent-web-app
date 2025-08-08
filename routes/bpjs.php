<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\views\BpjsViewController;
use App\Http\Controllers\Businesses\ReportController;
use App\Http\Controllers\businesses\BpjsTransactionController;

Route::middleware("auth")->group(function () {
    Route::post("/bpjs", [BpjsTransactionController::class, "search"])
        ->name("bpjs_transaction.find_bpjs_data");
    Route::post("/bpjs/pay", [BpjsTransactionController::class, "pay"])
        ->name("bpjs_transaction.pay");
    Route::get("/bpjs/receipt", action: [BpjsViewController::class, "showBpjsReceipt"])
        ->name("bpjs_transaction.receipt");

    Route::post("/report/bpjs", [ReportController::class, "getBpjsReport"])
        ->name("report.find_bpjs");
});