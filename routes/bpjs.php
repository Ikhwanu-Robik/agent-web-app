<?php

use App\Http\Controllers\utilities\ActiveBpjsController;
use App\Http\Controllers\utilities\BpjsTransactionController;
use App\Http\Controllers\utilities\ReportController;
use Illuminate\Support\Facades\Route;

Route::middleware("auth")->group(function () {
    Route::post("/bpjs", [ActiveBpjsController::class, "search"]);
    Route::post("/bpjs/pay", [BpjsTransactionController::class, "pay"]);
    Route::get("/bpjs/success", [BpjsTransactionController::class, "receipt"]);

    Route::post("/report/bpjs", [ReportController::class, "getBpjsReport"]);
});