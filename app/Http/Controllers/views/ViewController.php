<?php

namespace App\Http\Controllers\views;

use App\Models\Film;
use App\Models\Voucher;
use App\Models\BusStation;
use App\Models\CinemaFilm;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\utilities\ReportController;

class ViewController extends Controller
{
    public function showLoginForm()
    {
        return view("auth.login");
    }

    public function showRegisterForm()
    {
        return view("auth.register");
    }

    public function home()
    {
        return view("home");
    }

    public function vouchers()
    {
        $vouchers = Voucher::where("user_id", "=", Auth::id())->get();

        return view("vouchers", ["vouchers" => $vouchers]);
    }

    public function report(Request $request)
    {
        $service = $request->query("service") ? $request->query("service") : "";
        $reports = ReportController::getReport($service);

        return view("report", ["service" => $service, "reports" => $reports]);
    }

    public function busTicket()
    {
        return view("agent.bus_ticket.bus_ticket", ["bus_stations" => BusStation::all()]);
    }

    public function busPayment()
    {
        return view("agent.bus_ticket.payment_method");
    }

    public function busReceipt()
    {
        return view("agent.bus_ticket.receipt");
    }

    public function bpjs()
    {
        return view("agent.bpjs_subscription.bpjs_subscription");
    }

    public function showBpjsReceipt()
    {
        return view("agent.bpjs_subscription.receipt");
    }

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
        if (!session("film_ticket_transaction") || !session("seat_coordinates")) {
            return redirect("/film");
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

    public function game()
    {
        return view("agent.game_topup.game_topup");
    }

    public function gamePackage()
    {
        $game = null;
        // fetch the selected game model

        if (!$game) {
            return response("You need to choose a game to view this page");
        }

        return view("agent.game_topup.game_topup_package");
    }

    public function power()
    {
        return view("agent.electric_token.electric_token");
    }

    public function master()
    {
        return view("master.master");
    }
}
