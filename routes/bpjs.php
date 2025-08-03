<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\views\BpjsViewController;
use App\Http\Controllers\Businesses\ReportController;
use App\Http\Controllers\businesses\BpjsTransactionController;

Route::middleware("auth")->group(function () {
    Route::post("/bpjs", [BpjsTransactionController::class, "search"]);
    Route::post("/bpjs/pay", [BpjsTransactionController::class, "pay"]);
    Route::get("/bpjs/receipt", action: [BpjsViewController::class, "showBpjsReceipt"]);

    Route::post("/report/bpjs", [ReportController::class, "getBpjsReport"]);
});