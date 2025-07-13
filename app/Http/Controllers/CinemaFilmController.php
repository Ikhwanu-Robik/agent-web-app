<?php

namespace App\Http\Controllers;

use App\Models\CinemaFilm;
use App\Models\Film;
use App\Models\Cinema;
use Illuminate\Http\Request;
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
            "airing_datetime" => $validated["datetime_airing"]
        ];
        CinemaFilm::create($attributes);

        return redirect("/master/cinemas/" . $cinema->id . "/films");
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Film $film)
    {
        return view("master.film.edit", ["film" => $film]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Film $film)
    {
        $validated = $request->validate([
            "title" => "required|string",
            "poster" => "required|image",
            "release_date" => "required|date",
            "duration" => "required|numeric"
        ]);

        if (!$request->file("poster")->isValid()) {
            return response("Poster not uploaded successfully", 422);
        }
        Storage::disk("public")->delete($film->poster_image_url);
        $image_url = $request->file("poster")->storePublicly();

        $film->title = $validated["title"];
        $film->poster_image_url = $image_url;
        $film->release_date = $validated["release_date"];
        $film->duration = $validated["duration"];
        $film->save();

        return redirect("/master/films");
    }

    public function delete(Film $film)
    {
        return view("master.film.delete", ["film" => $film]);
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
