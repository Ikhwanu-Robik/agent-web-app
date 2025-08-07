<?php

namespace App\Http\Controllers\resources;

use App\Models\Cinema;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCinemaRequest;
use App\Http\Requests\UpdateCinemaRequest;

class CinemaController extends Controller
{
    public function index()
    {
        $cinemas = Cinema::all();

        return view("master.cinema.cinema", ["cinemas" => $cinemas]);
    }

    public function create()
    {
        return view("master.cinema.create");
    }

    public function store(StoreCinemaRequest $storeCinemaRequest)
    {
        Cinema::createSpecial($storeCinemaRequest->validated());

        return redirect("/master/cinemas");
    }

    public function edit(Cinema $cinema)
    {
        return view("master.cinema.edit", ["cinema" => $cinema]);
    }

    public function update(UpdateCinemaRequest $updateCinemaRequest, Cinema $cinema)
    {
        $cinema->updateSpecial($updateCinemaRequest->validated());

        return redirect("/master/cinemas");
    }

    public function delete(Cinema $cinema)
    {
        return view("master.cinema.delete", ["cinema" => $cinema]);
    }

    public function destroy(Request $request, Cinema $cinema)
    {
        $cinema->delete();

        return redirect("/master/cinemas");
    }
}
