<?php

namespace App\Http\Controllers;

use App\Models\Film;
use App\Models\Cinema;
use App\Models\CinemaFilm;
use App\Enums\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\FilmTicketTransaction;

class FilmTicketTransactionController extends Controller
{
    public function searchCinema(Request $request)
    {
        // $matchingCinemas = Cinema::join("cinema_film", "cinemas.id", "=", "cinema_film.cinema_id")->where("cinema_film.film_id", "=", $validated["film_id"])->get();
        $validated = $request->validate([
            "film_id" => "required|numeric|exists:films,id"
        ]);

        $cinemas = Cinema::with("films")->get();
        $searched_film = Film::find($validated["film_id"]);

        $matchingCinemas = [];

        // foreach each cinema
        // and foreach the film they scheduled
        // if the film is the film we are looking for
        // mark the cinema as 'matching'
        foreach ($cinemas as $cinema) {
            foreach ($cinema->films as $film) {
                if ($film->film_schedule->film_id == $validated["film_id"]) {
                    array_push($matchingCinemas, $cinema);
                }
            }
        }

        // foreach each cinema
        // and foreach film they scheduled
        // if the film is the film we are looking for
        // put it in temporary array, $matchingFilms
        // then replace the cinema's films with the
        // temporary array
        foreach ($matchingCinemas as $cinema) {
            $matchingFilms = [];

            foreach ($cinema->films as $film) {
                if ($film->title == $searched_film->title) {
                    array_push($matchingFilms, $film);
                }
            }

            $cinema->films = $matchingFilms;
        }

        return view("agent.film_ticket.film_ticket_cinema", ["cinemas" => $matchingCinemas]);
    }

    public function showBookSeatPage(Request $request)
    {
        $validated = $request->validate([
            "cinema_film_id" => "required|exists:cinema_film,id"
        ]);

        $cinemaFilm = CinemaFilm::with(["cinema", "film"])->find($validated["cinema_film_id"]);
        return view("agent.film_ticket.film_ticket_seat", ["film_schedule" => $cinemaFilm]);
    }

    public function order(Request $request)
    {
        $validated = $request->validate([
            "cinema_film_id" => "required|exists:cinema_film,id",
            "seat_coordinates" => "required|array"
        ]);

        $cinemaFilm = CinemaFilm::with("cinema", "film")->find($validated["cinema_film_id"]);

        $transactionAttributes = [
            "cinema_film_id" => $cinemaFilm->id,
            "seats_coordinates" => json_encode($validated["seat_coordinates"]),
            "total" => $cinemaFilm->ticket_price * count($validated["seat_coordinates"]),
        ];
        $filmTicketTransaction = FilmTicketTransaction::make($transactionAttributes);

        return redirect("/film/cinema/payment")
            ->with("film_ticket_transaction", $filmTicketTransaction)
            ->with("seat_coordinates", $validated["seat_coordinates"]);
    }

    public function showPaymentPage()
    {
        if (!session("film_ticket_transaction") || !session("seat_coordinates")) {
            return response("This content is unavailable for you", 404);
        }

        $film_ticket_transaction = session("film_ticket_transaction");
        $cinema_film = CinemaFilm::with(["cinema", "film"])->find($film_ticket_transaction->cinema_film_id);
        $film_ticket_transaction->cinema_film = $cinema_film;

        session()->reflash();
        
        return view("agent.film_ticket.film_ticket_payment", [
            "film_ticket_transaction" => $film_ticket_transaction,
            "seat_coordinates" => session("seat_coordinates")
        ]);
    }

    public function makeTransaction(Request $request)
    {
        $validated = $request->validate([
            "payment_method" => [
                "required",
                Rule::enum(PaymentMethod::class)
            ]
        ]);

        $transaction = session("film_ticket_transaction");

        $cinemaFilm = CinemaFilm::find($transaction->cinema_film->id);
        $newSeats = json_decode($cinemaFilm->seats_status);
        foreach (session("seat_coordinates") as $seat_coord) {
            $col = explode(",", $seat_coord)[0];
            $row = explode(",", $seat_coord)[1];

            $newSeats[$row][$col] = 1;
        }
        $cinemaFilm->seats_status = json_encode($newSeats);
        $cinemaFilm->save();

        if ($validated["payment_method"] == "cash") {
            // TODO: add the column, verdamt!
            // $transaction->payment_method = "cash";
        } else if ($validated["payment_method"] == "flip") {
            // call Flip's API
        }

        unset($transaction->cinema_film);
        $transaction->save();

        session()->reflash();
        session()->flash("payment_method", $validated["payment_method"]);
        session()->flash("payment_status", "success");

        return redirect("/film/cinema/seats/transaction/success");
    }

    public function showReceipt()
    {
        if (!session("film_ticket_transaction") || !session("seat_coordinates")) {
            return response("This content is unavailable for you", 404);
        }

        $film_ticket_transaction = session("film_ticket_transaction");
        $cinema_film = CinemaFilm::with(["cinema", "film"])->find($film_ticket_transaction->cinema_film_id);
        $film_ticket_transaction->cinema_film = $cinema_film;
        $film_ticket_transaction->payment_method = session("payment_method");
        $film_ticket_transaction->payment_status = session("payment_status");

        return view("agent.film_ticket.receipt", [
            "film_ticket_transaction" => $film_ticket_transaction,
            "seat_coordinates" => session("seat_coordinates"),
        ]);
    }
}
