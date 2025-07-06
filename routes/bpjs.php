<?php

use App\Http\Controllers\ActiveBpjsController;
use App\Models\ActiveBpjs;
use Illuminate\Support\Facades\Route;

Route::middleware("auth")->group(function () {
    Route::post("/bpjs", [ActiveBpjsController::class, "search"]);
});

Route::get("/test", function () {
    $bpjs = ActiveBpjs::where("id", "=", "1")->first();
    $bpjs->isStillActive = $bpjs->isStillActive();
    return $bpjs;
});