<?php

use App\Http\Controllers\FilmTicketTransactionController;

Route::middleware("auth")->group(function () {
    Route::post("/film/cinema", [FilmTicketTransactionController::class, "searchCinema"]);
    // Route::get("/film/cinema", [ViewController::class, "filmCinema"]);
    // Route::get("/film/cinema/seat", [ViewController::class, "cinemaSeat"]);
});