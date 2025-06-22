<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ViewController extends Controller
{
    public function home()
    {
        return view("home");
    }

    public function busTicket()
    {
        return view("agent.bus_ticket");
    }

    public function bpjs()
    {
        return view("agent.bpjs_subscription");
    }

    public function filmTicket()
    {
        return view("agent.film_ticket");
    }

    public function filmCinema()
    {
        $film = null;
        //fetch the selected film model

        if (!$film) {
            return response("You need to choose a film to view this page", 401);
        }

        return view("agent.film_ticket_cinema");
    }

    public function cinemaSeat()
    {
        $cinema = null;
        // fetch the selecteld cinema model

        if (!$cinema) {
            return response("You need to choose a cinema to view this page", 401);
        }

        return view("agent.film_ticket_seat");
    }

    public function game()
    {
        return view("agent.game_topup");
    }

    public function gamePackage()
    {
        $game = null;
        // fetch the selected game model

        if (!$game) {
            return response("You need to choose a game to view this page");
        }

        return view("agent.game_topup_package");
    }

    public function power()
    {
        return view("agent.electric_token");
    }

    public function master() {
        return view("master.master");
    }
}
