<?php

namespace App\Http\Controllers\resources;

use App\Http\Requests\DestroyCinemaFilmRequest;
use Closure;
use Carbon\Carbon;
use App\Models\Film;
use App\Models\Cinema;
use App\Models\CinemaFilm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\StoreCinemaFilmRequest;

class CinemaFilmController extends Controller
{
    public function index(Cinema $cinema)
    {
        $cinemaWithFilms = Cinema::with("films")->find($cinema->id);

        return view("master.cinema.films.films", ["cinemaWithFilms" => $cinemaWithFilms]);
    }

    public function create(Cinema $cinema)
    {
        $films = Film::all();

        return view("master.cinema.films.add", ["cinema" => $cinema, "films" => $films]);
    }

    public function store(StoreCinemaFilmRequest $storeCinemaFilmRequest, Cinema $cinema)
    {
        $validated = $storeCinemaFilmRequest->validated();

        $attributes = [
            "cinema_id" => $cinema->id,
            "film_id" => $validated["film"],
            "ticket_price" => $validated["ticket_price"],
            "airing_datetime" => Carbon::make($validated["datetime_airing"]),
            "seats_status" => $cinema->seats_structure
        ];
        CinemaFilm::create($attributes);

        return redirect("/master/cinemas/" . $cinema->id . "/films");
    }

    public function destroy(DestroyCinemaFilmRequest $destroyCinemaFilmRequest, Cinema $cinema, string $cinema_film)
    {
        CinemaFilm::where("id", "=", $cinema_film)->delete();

        return redirect("/master/cinemas/" . $cinema->id . "/films");
    }
}
