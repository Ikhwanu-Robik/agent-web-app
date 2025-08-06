<?php

namespace App\Http\Controllers\businesses;

use App\Http\Requests\GetAiringCinemaRequest;
use App\Http\Requests\OrderFilmTicketRequest;
use App\Http\Requests\PayFilmTicketRequest;
use App\Services\FlipTransaction;
use App\Models\Cinema;
use App\Models\CinemaFilm;
use App\Http\Controllers\Controller;
use App\Models\FilmTicketTransaction;

class FilmTicketTransactionController extends Controller
{
    public function searchCinema(GetAiringCinemaRequest $getAiringCinemaRequest)
    {
        $validated = $getAiringCinemaRequest->validated();
        $matching_cinemas = Cinema::findAiring($validated["film_id"]);

        return redirect("/film/cinema")->with("cinemas", $matching_cinemas);
    }

    public function order(OrderFilmTicketRequest $orderFilmTicketRequest)
    {
        $validated = $orderFilmTicketRequest->validated();
        $filmTicketTransaction = FilmTIcketTransaction::createOrder($validated);

        return redirect("/film/cinema/payment")
            ->with("film_ticket_transaction", $filmTicketTransaction)
            ->with("seat_coordinates", $validated["seat_coordinates"]);
    }

    public function makeTransaction(PayFilmTicketRequest $payFilmTicketRequest, FlipTransaction $flipTransaction)
    {
        $validated = $payFilmTicketRequest->validated();

        $transaction = session("film_ticket_transaction");

        $flipResponse = $transaction->processPayment($flipTransaction, $validated);

        CinemaFilm::find($transaction->cinemaFilm->id)->updateAvailableSeats($transaction);

        return redirect("/film/cinema/seats/transaction/success")
            ->with("transaction", $transaction)
            ->with("flip_response", $flipResponse);
    }
}
