<?php

namespace App\Http\Controllers;

use App\Models\Film;
use App\Models\Cinema;
use Illuminate\Http\Request;

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

    // "agent.film_ticket.film_ticket_seat"
}