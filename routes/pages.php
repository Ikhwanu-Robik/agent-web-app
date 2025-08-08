<?php

use App\Http\Controllers\views\GeneralViewController;
use App\Http\Controllers\views\BusTicketViewController;
use App\Http\Controllers\views\GameTopupViewController;
use App\Http\Controllers\views\FilmTicketViewController;
use App\Http\Controllers\views\PowerTopupViewController;
use App\Http\Controllers\views\BpjsViewController;
use Illuminate\Support\Facades\Route;

Route::middleware("auth")->group(function () {
    Route::get('/', [GeneralViewController::class, "home"])->name("home");

    Route::get("/report", [GeneralViewController::class, "report"])->name("report");
    Route::get("/vouchers", [GeneralViewController::class, "vouchers"])->name("vouchers");

    Route::get("/bus/ticket", [BusTicketViewController::class, "busTicket"])
        ->name("bus_ticket_transaction.select_schedule");
    Route::get("/bpjs", [BpjsViewController::class, "bpjs"])
        ->name("bpjs_transaction.form");
    Route::get("/film", [FilmTicketViewController::class, "filmTicket"])
        ->name("film_ticket_transaction.select_film");
    Route::get("/game/topup", [GameTopupViewController::class, "selectGame"])
        ->name("game_top_up_transaction.select_game");
    Route::get("/power", [PowerTopupViewController::class, "showPowerTopUpForm"])
        ->name("power_top_up_transaction.form");
});