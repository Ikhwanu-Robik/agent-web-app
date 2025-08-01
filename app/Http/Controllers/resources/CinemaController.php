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
        $validated = $updateCinemaRequest->validated();
        $seats_structure = json_decode($cinema->seats_structure);

        $cinema->name = $validated["name"];
        if (isset($validated["seats_structure"])) {
            $nSeats_structure = $seats_structure;

            foreach ($validated["seats_structure"] as $filledCoordinate) {
                $filledY = explode(",", $filledCoordinate)[0];
                $filledX = explode(",", $filledCoordinate)[1];

                $nSeats_structure[$filledY][$filledX] = 1;
            }

            $cinema->seats_structure = json_encode($nSeats_structure);
        } else if (isset($validated["seats_structure_width"]) && isset($validated["seats_structure_height"])) {
            $nSeats_structure = [];
            for ($nRow = 0; $nRow < $validated["seats_structure_height"]; $nRow++) {
                for ($nCol = 0; $nCol < $validated["seats_structure_width"]; $nCol++) {
                    $nSeats_structure[$nRow][$nCol] = 0;
                }
            }

            $cinema->seats_structure = json_encode($nSeats_structure);
        }
        $cinema->save();

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
