<?php

namespace App\Http\Controllers;

use App\Models\Voucher;
use App\Models\BusStation;
use Illuminate\Http\Request;
use App\Models\BusTicketTransaction;
use Illuminate\Support\Facades\Auth;

class ViewController extends Controller
{
    public function home()
    {
        return view("home");
    }

    public function report(Request $request)
    {
        switch ($request->query("service")) {
            case "bus-ticket":
                $bus_ticket_transactions = BusTicketTransaction::where("user_id", "=", Auth::id())
                    ->with(["busSchedule", "busSchedule.bus", "busSchedule.originStation", "busSchedule.destinationStation"])
                    ->get();

                return view("report", ["bus_ticket_transactions" => $bus_ticket_transactions]);
            default:
                $bus_ticket_transactions = BusTicketTransaction::where("user_id", "=", Auth::id())
                    ->with(["busSchedule", "busSchedule.bus", "busSchedule.originStation", "busSchedule.destinationStation"])
                    ->get();

                return view("report", ["bus_ticket_transactions" => $bus_ticket_transactions]);
        }
    }

    public function vouchers()
    {
        $vouchers = Voucher::where("user_id", "=", Auth::id())->get();

        return view("vouchers", ["vouchers" => $vouchers]);
    }

    public function busTicket()
    {
        return view("agent.bus_ticket.bus_ticket", ["bus_stations" => BusStation::all()]);
    }

    public function bpjs()
    {
        return view("agent.bpjs_subscription.bpjs_subscription");
    }

    public function filmTicket()
    {
        return view("agent.film_ticket.film_ticket");
    }

    public function filmCinema()
    {
        $film = null;
        //fetch the selected film model

        if (!$film) {
            return response("You need to choose a film to view this page", 401);
        }

        return view("agent.film_ticket.film_ticket_cinema");
    }

    public function cinemaSeat()
    {
        $cinema = null;
        // fetch the selecteld cinema model

        if (!$cinema) {
            return response("You need to choose a cinema to view this page", 401);
        }

        return view("agent.film_ticket.film_ticket_seat");
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
