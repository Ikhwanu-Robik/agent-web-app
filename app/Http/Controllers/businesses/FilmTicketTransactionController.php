<?php

namespace App\Http\Controllers\businesses;

use App\Models\Film;
use App\Models\Cinema;
use App\Http\Controllers\Controller;
use App\Models\FilmTicketTransaction;
use App\Http\Requests\PayFilmTicketRequest;
use App\Http\Requests\GetAiringCinemaRequest;
use App\Http\Requests\OrderFilmTicketRequest;

class FilmTicketTransactionController extends Controller
{
    public function search(GetAiringCinemaRequest $getAiringCinemaRequest, Film $film)
    {
        $validated = $getAiringCinemaRequest->validated();
        $matchingCinemas = Cinema::findAiring($validated["film_id"]);

        return redirect()->route("film_ticket_transaction.show_airing_cinema", ["film" => $film->id])
            ->with("cinemas", $matchingCinemas);
    }

    public function order(OrderFilmTicketRequest $orderFilmTicketRequest, Film $film, Cinema $cinema)
    {
        $validated = $orderFilmTicketRequest->validated();
        $filmTicketTransaction = FilmTIcketTransaction::createOrder($validated);
        $filmTicketTransaction->appendCinemaDetails();

        return redirect()
            ->route("film_ticket_transaction.select_payment_method", [
                "film" => $film->id,
                "cinema" => $cinema->id,
                "schedule" => $filmTicketTransaction->cinema_film->id
            ])
            ->with("film_ticket_transaction", $filmTicketTransaction)
            ->with("seat_coordinates", $validated["seat_coordinates"]);
    }

    public function pay(PayFilmTicketRequest $payFilmTicketRequest, Film $film, Cinema $cinema)
    {
        $validated = $payFilmTicketRequest->validated();

        $transaction = session("film_ticket_transaction");

        $flipResponse = $transaction->processPayment($validated);

        if ($transaction->status == "SUCCESSFUL") {
            $transaction->CinemaFilm->updateAvailableSeats(json_decode($transaction->seats_coordinates));
        }

        return redirect()
            ->route("film_ticket_transaction.receipt", [
                "film" => $film->id,
                "cinema" => $cinema->id,
                "schedule" => $transaction->cinema_film->id
            ])
            ->with("transaction", $transaction)
            ->with("flip_response", $flipResponse);
    }
}
