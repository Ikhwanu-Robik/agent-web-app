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
        CinemaFilm::createSpecial($storeCinemaFilmRequest->validated(), $cinema);

        return redirect("/master/cinemas/" . $cinema->id . "/films");
    }

    public function destroy(DestroyCinemaFilmRequest $destroyCinemaFilmRequest, Cinema $cinema, string $cinema_film)
    {
        CinemaFilm::where("id", "=", $cinema_film)->delete();

        return redirect("/master/cinemas/" . $cinema->id . "/films");
    }
}
