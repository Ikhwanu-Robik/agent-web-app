<?php

use App\Http\Controllers\FilmTicketTransactionController;

Route::middleware("auth")->group(function () {
    // for debugging
    // TODO: refactor the routing to separate route for page and route for process
    Route::get("/film/cinema", function () {
        return session()->all();
    });
    Route::post("/film/cinema", [FilmTicketTransactionController::class, "searchCinema"]);
    // the below three routes should be a good example to follow for routing
    // /film/cinema/seats returns a view, in this view there is a form which leads to
    // /film/cinema/seats/book, which returns a redirect with session to
    // /film/cinema/transaction, which ensures the session exist
    // before returning a view with the session as data
    Route::get("/film/cinema/seats", [FilmTicketTransactionController::class, "showBookSeatPage"]);
    Route::post("/film/cinema/seats/book", [FilmTicketTransactionController::class, "order"]);
    Route::get("/film/cinema/payment", [FilmTicketTransactionController::class, "showPaymentPage"]);
    Route::post("/film/cinema/transaction", [FilmTicketTransactionController::class, "makeTransaction"]);
    Route::get("/film/cinema/seats/transaction/success", [FilmTicketTransactionController::class, "showReceipt"]);
});