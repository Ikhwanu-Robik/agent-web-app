<?php

use App\Http\Controllers\views\GeneralViewController;
use App\Http\Controllers\views\BusTicketViewController;
use App\Http\Controllers\views\GameTopupViewController;
use App\Http\Controllers\views\FilmTicketViewController;
use App\Http\Controllers\views\PowerTopupViewController;
use App\Http\Controllers\views\BpjsViewController;
use Illuminate\Support\Facades\Route;

Route::middleware("auth")->group(function () {
    Route::get('/', [GeneralViewController::class, "home"]);

    Route::get("/report", [GeneralViewController::class, "report"]);
    Route::get("/vouchers", [GeneralViewController::class, "vouchers"]);

    Route::get("/bus/ticket", [BusTicketViewController::class, "busTicket"]);
    Route::get("/bpjs", [BpjsViewController::class, "bpjs"]);
    Route::get("/film", [FilmTicketViewController::class, "filmTicket"]);
    Route::get("/game/topup", [GameTopupViewController::class, "selectGame"]);
    Route::get("/game/topup/package", [GameTopupViewController::class, "gamePackage"]);
    Route::get("/power", [PowerTopupViewController::class, "power"]);
});