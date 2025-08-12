<?php

namespace App\Http\Controllers\businesses;

use App\Http\Requests\GetAiringCinemaRequest;
use App\Http\Requests\OrderFilmTicketRequest;
use App\Http\Requests\PayFilmTicketRequest;
use App\Models\Cinema;
use App\Http\Controllers\Controller;
use App\Models\FilmTicketTransaction;

class FilmTicketTransactionController extends Controller
{
    public function search(GetAiringCinemaRequest $getAiringCinemaRequest)
    {
        $validated = $getAiringCinemaRequest->validated();
        $matchingCinemas = Cinema::findAiring($validated["film_id"]);

        return redirect()->route("film_ticket_transaction.show_airing_cinema")->with("cinemas", $matchingCinemas);
    }

    public function order(OrderFilmTicketRequest $orderFilmTicketRequest)
    {
        $validated = $orderFilmTicketRequest->validated();
        $filmTicketTransaction = FilmTIcketTransaction::createOrder($validated);
        $filmTicketTransaction->appendCinemaDetails();

        return redirect()
            ->route("film_ticket_transaction.select_payment_method")
            ->with("film_ticket_transaction", $filmTicketTransaction)
            ->with("seat_coordinates", $validated["seat_coordinates"]);
    }

    public function pay(PayFilmTicketRequest $payFilmTicketRequest)
    {
        $validated = $payFilmTicketRequest->validated();

        $transaction = session("film_ticket_transaction");

        $flipResponse = $transaction->processPayment($validated);

        if ($transaction->status == "SUCCESSFUL") {
            $transaction->CinemaFilm->updateAvailableSeats(json_decode($transaction->seats_coordinates));
        }

        return redirect()
            ->route("film_ticket_transaction.receipt")
            ->with("transaction", $transaction)
            ->with("flip_response", $flipResponse);
    }
}
