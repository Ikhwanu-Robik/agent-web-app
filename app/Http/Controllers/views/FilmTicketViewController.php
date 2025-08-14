<?php

namespace App\Http\Controllers\views;

use App\Models\Film;
use App\Models\Cinema;
use App\Models\Voucher;
use App\Models\CinemaFilm;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FilmTicketViewController extends Controller
{
    public function showFilms()
    {
        $films = Film::all();

        return view("agent.film-ticket.film-ticket", ["films" => $films]);
    }

    public function showAiringCinemas()
    {
        $cinemas = session("cinemas");
        if (!$cinemas) {
            return redirect()->route("film_ticket_transaction.select_film");
        }

        return view("agent.film-ticket.film-ticket-cinema", ["cinemas" => $cinemas]);
    }

    public function showSelectSeatForm(Request $request, Film $film, Cinema $cinema, CinemaFilm $schedule)
    {
        $cinemaFilm = CinemaFilm::with(["cinema", "film"])->find($schedule->id);
        return view("agent.film-ticket.film-ticket-seat", ["filmSchedule" => $cinemaFilm]);
    }

    public function showPaymentForm()
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

    public function showReceipt()
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