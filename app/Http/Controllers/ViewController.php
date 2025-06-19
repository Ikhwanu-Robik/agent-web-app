<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ViewController extends Controller
{
    public function home() {
        return view("home");
    }

    public function busTicket() {
        return view("bus_ticket");
    }

    public function bpjs() {
        return view("bpjs_subscription");
    }

    public function filmTicket() {
        return view("film_ticket");
    }

    public function filmCinema() {
        $film = null;
        //fetch the selected film model

        if (!$film) {
            return response("You need to choose a film to view this page", 401);
        }

        return view("film_ticket_cinema");
    }

    public function cinemaSeat() {
        $cinema = null;
        // fetch the selecteld cinema model

        if (!$cinema) {
            return response("You need to choose a cinema to view this page", 401);
        }

        return view("film_ticket_seat");
    }
}
