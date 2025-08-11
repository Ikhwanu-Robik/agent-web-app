<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\views\FilmTicketViewController;
use App\Http\Controllers\businesses\FilmTicketTransactionController;

Route::middleware("auth")->group(function () {
    Route::post("/film/cinema", [FilmTicketTransactionController::class, "search"])
        ->name("film_ticket_transaction.find_airing_cinema");
    Route::get("/film/cinema", [FilmTicketViewController::class, "showAiringCinemaPage"])
        ->name("film_ticket_transaction.show_airing_cinema");
    Route::get("/film/cinema/seats", [FilmTicketViewController::class, "showFilmBookSeatPage"])
        ->name("film_ticket_transaction.show_book_seat_form");
    Route::post("/film/cinema/seats", [FilmTicketTransactionController::class, "order"])
        ->name("film_ticket_transaction.book_seat");
    Route::get("/film/cinema/payment", [FilmTicketViewController::class, "showFilmPaymentPage"])
        ->name("film_ticket_transaction.select_payment_method");
    Route::post("/film/cinema/pay", [FilmTicketTransactionController::class, "pay"])
        ->name("film_ticket_transaction.pay");
    Route::get("/film/cinema/seats/transaction/receipt", [FilmTicketViewController::class, "showFilmReceipt"])
        ->name("film_ticket_transaction.receipt");
});