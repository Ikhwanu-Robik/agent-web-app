<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\views\ViewController;

Route::middleware("auth")->group(function () {
    Route::get('/', [ViewController::class, "home"]);

    Route::get("/report", [ViewController::class, "report"]);
    Route::get("/vouchers", [ViewController::class, "vouchers"]);
    
    Route::get("/bus/ticket", [ViewController::class, "busTicket"]);
    Route::get("/bpjs", [ViewController::class, "bpjs"]);
    Route::get("/film", [ViewController::class, "filmTicket"]);
    Route::get("/game/topup", [ViewController::class, "game"]);
    Route::get("/game/topup/package", [ViewController::class, "gamePackage"]);
    Route::get("/power", [ViewController::class, "power"]);
});