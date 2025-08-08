<?php

namespace App\Http\Controllers\views;

use App\Models\Film;
use App\Models\Voucher;
use App\Models\CinemaFilm;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FilmTicketViewController extends Controller
{
    public function filmTicket()
    {
        $films = Film::all();

        return view("agent.film-ticket.film-ticket", ["films" => $films]);
    }

    public function showAiringCinemaPage()
    {
        $cinemas = session("cinemas");
        if (!$cinemas) {
            return redirect()->route("film_ticket_transaction.select_film");
        }

        return view("agent.film-ticket.film-ticket-cinema", ["cinemas" => $cinemas]);
    }

    public function showFilmBookSeatPage(Request $request)
    {
        $validated = $request->validate([
            "cinema_film_id" => "required|exists:cinema_film,id"
        ]);

        $cinemaFilm = CinemaFilm::with(["cinema", "film"])->find($validated["cinema_film_id"]);
        return view("agent.film-ticket.film-ticket-seat", ["filmSchedule" => $cinemaFilm]);
    }

    public function showFilmPaymentPage()
    {
        if (!session("film_ticket_transaction") || !session("seat_coordinates")) {
            return redirect()->route("film_ticket_transaction.select_film");
        }

        $filmTicketTransaction = session("film_ticket_transaction");
        
        $validVouchers = Voucher::getValidVouchers("film_ticket");

        session()->reflash();

        return view("agent.film-ticket.film-ticket-payment", [
            "filmTicketTransaction" => $filmTicketTransaction,
            "seatCoordinates" => session("seat_coordinates"),
            "vouchers" => $validVouchers
        ]);
    }

    public function showFilmReceipt()
    {
        if (!session("transaction")) {
            return redirect()->route("film_ticket_transaction.select_film");
        }

        $filmTicketTransaction = session("transaction");
        $flipResponse = session("flip_response");

        return view("agent.film-ticket.receipt", [
            "filmTicketTransaction" => $filmTicketTransaction,
            "flipResponse" => $flipResponse
        ]);
    }
}