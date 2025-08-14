<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\views\FilmTicketViewController;
use App\Http\Controllers\businesses\FilmTicketTransactionController;

Route::middleware("auth")->group(function () {
    Route::get("/films", [FilmTicketViewController::class, "showFilms"])
        ->name("film_ticket_transaction.select_film");
    Route::post("/films/{film}/cinemas", [FilmTicketTransactionController::class, "search"])
        ->name("film_ticket_transaction.find_airing_cinema");
    Route::get("/films/{film}/cinemas", [FilmTicketViewController::class, "showAiringCinemas"])
        ->name("film_ticket_transaction.show_airing_cinema");
    Route::post("/films/{film}/cinemas/{cinema}/schedules/{schedule}/order", [FilmTicketTransactionController::class, "order"])
        ->name("film_ticket_transaction.book_seat");
    Route::get("/films/{film}/cinemas/{cinema}/schedules/{schedule}/select-seat", [FilmTicketViewController::class, "showSelectSeatForm"])
        ->name("film_ticket_transaction.show_book_seat_form");
    Route::get("/films/{film}/cinemas/{cinema}/schedules/{schedule}/select-payment", [FilmTicketViewController::class, "showPaymentForm"])
        ->name("film_ticket_transaction.select_payment_method");
    Route::post("/films/{film}/cinemas/{cinema}/schedules/{schedule}/pay", [FilmTicketTransactionController::class, "pay"])
        ->name("film_ticket_transaction.pay");
    Route::get("/films/{film}/cinemas/{cinema}/schedules/{schedule}/receipt", [FilmTicketViewController::class, "showReceipt"])
        ->name("film_ticket_transaction.receipt");
});