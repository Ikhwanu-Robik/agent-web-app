<?php

use App\Http\Controllers\ActiveBpjsController;
use App\Http\Controllers\BpjsTransactionController;
use App\Models\ActiveBpjs;
use Illuminate\Support\Facades\Route;

Route::middleware("auth")->group(function () {
    Route::post("/bpjs", [ActiveBpjsController::class, "search"]);
    Route::post("/bpjs/pay", [BpjsTransactionController::class, "pay"]);
    Route::get("/bpjs/success", [BpjsTransactionController::class, "receipt"]);

    Route::post("/report/bpjs", [BpjsTransactionController::class, "report"]);
});