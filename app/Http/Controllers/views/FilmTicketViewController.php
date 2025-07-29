<?php

namespace App\Http\Controllers\views;

use App\Models\Film;
use App\Models\Voucher;
use App\Models\CinemaFilm;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class FilmTicketViewController extends Controller
{
    public function filmTicket()
    {
        $films = Film::all();

        return view("agent.film_ticket.film_ticket", ["films" => $films]);
    }

    public function showAiringCinemaPage()
    {
        $cinemas = session("cinemas");
        if (!$cinemas) {
            return redirect("/film");
        }

        return view("agent.film_ticket.film_ticket_cinema", ["cinemas" => $cinemas]);
    }

    public function showFilmBookSeatPage(Request $request)
    {
        $validated = $request->validate([
            "cinema_film_id" => "required|exists:cinema_film,id"
        ]);

        $cinemaFilm = CinemaFilm::with(["cinema", "film"])->find($validated["cinema_film_id"]);
        return view("agent.film_ticket.film_ticket_seat", ["film_schedule" => $cinemaFilm]);
    }

    public function showFilmPaymentPage()
    {
        if (!session("film_ticket_transaction") || !session("seat_coordinates")) {
            return redirect("/film");
        }

        $film_ticket_transaction = session("film_ticket_transaction");
        $cinema_film = CinemaFilm::with(["cinema", "film"])->find($film_ticket_transaction->cinema_film_id);
        $film_ticket_transaction->cinema_film = $cinema_film;
        $vouchers = Voucher::where("user_id", "=", Auth::id())->get();
        $valid_vouchers = [];
        foreach ($vouchers as $voucher) {
            $valid_services = json_decode($voucher->valid_for);

            foreach ($valid_services as $service) {
                if ($service == "film_ticket") {
                    array_push($valid_vouchers, $voucher);
                }
            }
        }

        session()->reflash();

        return view("agent.film_ticket.film_ticket_payment", [
            "film_ticket_transaction" => $film_ticket_transaction,
            "seat_coordinates" => session("seat_coordinates"),
            "vouchers" => $valid_vouchers
        ]);
    }

    public function showFilmReceipt()
    {
        if (!session("transaction")) {
            return redirect("/film");
        }

        $film_ticket_transaction = session("transaction");
        $flipResponse = session("flip_response");

        return view("agent.film_ticket.receipt", [
            "film_ticket_transaction" => $film_ticket_transaction,
            "flipResponse" => $flipResponse
        ]);
    }
}