<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\views\FilmTicketViewController;
use App\Http\Controllers\utilities\FilmTicketTransactionController;

Route::middleware("auth")->group(function () {
    Route::post("/film/cinema", [FilmTicketTransactionController::class, "searchCinema"]);
    Route::get("/film/cinema", [FilmTicketViewController::class, "showAiringCinemaPage"]);
    Route::get("/film/cinema/seats", [FilmTicketViewController::class, "showFilmBookSeatPage"]);
    Route::post("/film/cinema/seats/book", [FilmTicketTransactionController::class, "order"]);
    Route::get("/film/cinema/payment", [FilmTicketViewController::class, "showFilmPaymentPage"]);
    Route::post("/film/cinema/transaction", [FilmTicketTransactionController::class, "makeTransaction"]);
    Route::get("/film/cinema/seats/transaction/success", [FilmTicketViewController::class, "showFilmReceipt"]);
});