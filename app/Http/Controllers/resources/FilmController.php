<?php

namespace App\Http\Controllers\resources;

use App\Models\Film;
use Closure;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class FilmController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $films = Film::all();

        return view("master.film.film", ["films" => $films]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("master.film.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "title" => "required|string",
            "poster" => [
                "required",
                "image",
                function (string $attributes, mixed $value, Closure $fail) {
                    if (!$value->isValid()) {
                        $fail("{$attributes} not uploaded succesfully");
                    }
                }
            ],
            "release_date" => "required|date",
            "duration" => "required|numeric"
        ]);

        $validated = $validator->validated();
        $image_url = $request->file("poster")->storePublicly();

        $attributes = [
            "title" => $validated["title"],
            "poster_image_url" => $image_url,
            "release_date" => $validated["release_date"],
            "duration" => $validated["duration"]
        ];
        Film::create($attributes);

        return redirect("/master/films");
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
        $validator = Validator::make($request->all(), [
            "title" => "required|string",
            "poster" => [
                "required",
                "image",
                function (string $attributes, mixed $value, Closure $fail) {
                    if (!$value->isValid()) {
                        $fail("{$attributes} not uploaded succesfully");
                    }
                }
            ],
            "release_date" => "required|date",
            "duration" => "required|numeric"
        ]);

        $validated = $validator->validated();
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
    public function destroy(Request $request, Film $film)
    {
        $validated = $request->validate([
            "film" => "required|numeric|exists:films,id"
        ]);

        Storage::disk("public")->delete($film->poster_image_url);
        $film->delete();

        return redirect("/master/films");
    }
}
