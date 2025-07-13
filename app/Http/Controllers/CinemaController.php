<?php

namespace App\Http\Controllers;

use App\Models\Cinema;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class CinemaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cinemas = Cinema::all();

        return view("master.cinema.cinema", ["cinemas" => $cinemas]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("master.cinema.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            "name" => "required|string",
            "seats_structure_width" => "required|numeric",
            "seats_structure_height" => "required|numeric"
        ]);

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

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cinema $cinema)
    {
        return view("master.cinema.edit", ["cinema" => $cinema]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cinema $cinema)
    {
        $seats_structure = json_decode($cinema->seats_structure);
        $oriRow = count($seats_structure);
        $oriCol = count($seats_structure[0]);

        $validated = $request->validate([
            "name" => "required|string",
            "seats_structure" => ["missing_unless:seats_structure_width,$oriCol", "missing_unless:seats_structure_height,$oriRow", "array"],
            "seats_structure_width" => ["exclude_with:seats_structure", "required_with:seats_structure_height", "numeric"],
            "seats_structure_height" => ["exclude_with:seats_structure", "required_with:seats_structure_width", "numeric"]
        ]);

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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Cinema $cinema)
    {
        $validated = $request->validate([
            "cinema" => "required|numeric|exists:cinemas,id"
        ]);

        $cinema->delete();

        return redirect("/master/cinemas");
    }
}
