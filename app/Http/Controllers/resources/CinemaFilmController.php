<?php

namespace App\Http\Controllers\resources;

use Carbon\Carbon;
use App\Models\Film;
use App\Models\Cinema;
use App\Models\CinemaFilm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class CinemaFilmController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Cinema $cinema)
    {
        $cinemaWithFilms = Cinema::with("films")->find($cinema->id);

        return view("master.cinema.films.films", ["cinemaWithFilms" => $cinemaWithFilms]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Cinema $cinema)
    {
        $films = Film::all();

        return view("master.cinema.films.add", ["cinema" => $cinema, "films" => $films]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Cinema $cinema)
    {
        $validated = $request->validate([
            "film" => "required|exists:films,id",
            "ticket_price" => "required|numeric",
            "datetime_airing" => "required|date"
        ]); 

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

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Film $film)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Film $film)
    {
        //
    }

    public function delete(Film $film)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Cinema $cinema, string $cinema_film)
    {
        $validated = $request->validate([
            "schedule_id" => "required|numeric|exists:cinema_film,id"
        ]);

        if (!$cinema_film) {
            return response("The given schedule is invalid", 422);
        }
        CinemaFilm::where("id", "=", $cinema_film)->delete();

        return redirect("/master/cinema/" . $cinema->id . "/films");
    }
}
