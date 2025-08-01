<?php

namespace App\Http\Controllers\resources;

use App\Http\Requests\StoreFilmRequest;
use App\Http\Requests\UpdateFilmRequest;
use App\Models\Film;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class FilmController extends Controller
{
    public function index()
    {
        $films = Film::all();

        return view("master.film.film", ["films" => $films]);
    }

    public function create()
    {
        return view("master.film.create");
    }

    public function store(StoreFilmRequest $storeFilmRequest)
    {
        Film::createSpecial($storeFilmRequest);

        return redirect("/master/films");
    }

    public function edit(Film $film)
    {
        return view("master.film.edit", ["film" => $film]);
    }

    public function update(UpdateFilmRequest $updateFilmRequest, Film $film)
    {
        $film->deleteImage();
        $film->saveImage($updateFilmRequest->file("poster"));
        $film->updateSpecial($updateFilmRequest->validated());

        return redirect("/master/films");
    }

    public function delete(Film $film)
    {
        return view("master.film.delete", ["film" => $film]);
    }

    public function destroy(Request $request, Film $film)
    {
        Storage::disk("public")->delete($film->poster_image_url);
        $film->delete();

        return redirect("/master/films");
    }
}
