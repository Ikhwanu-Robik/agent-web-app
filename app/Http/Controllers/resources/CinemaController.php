<?php

namespace App\Http\Controllers\resources;

use App\Models\Cinema;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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
        $validated = $storeCinemaRequest->validated();

        $seats_structure = [];
        for ($row = 0; $row < $validated["seats_structure_height"]; $row++) {
            for ($col = 0; $col < $validated["seats_structure_width"]; $col++) {
                $seats_structure[$row][$col] = 0;
            }
        }

        $attributes = [
            "name" => $validated["name"],
            "seats_structure" => json_encode($seats_structure)
        ];
        Cinema::create($attributes);

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
