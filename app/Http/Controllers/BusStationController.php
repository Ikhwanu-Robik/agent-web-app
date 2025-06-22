<?php

namespace App\Http\Controllers;

use App\Models\BusStation;
use Illuminate\Http\Request;

class BusStationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bus_stations = BusStation::all();

        return view("master.bus_station.bus_station", ["bus_stations" => $bus_stations]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("master.bus_station.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            "name" => "required|string"
        ]);

        BusStation::create($validated);

        return redirect("/master/bus/station");
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BusStation $bus_station)
    {
        return view("master.bus_station.edit", ["bus_station" => $bus_station]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BusStation $bus_station)
    {
        $validated = $request->validate([
            "name" => "required|string"
        ]);

        $bus_station->name = $validated["name"];
        $bus_station->save();

        return redirect("/master/bus/station");
    }

    public function delete(BusStation $bus_station) {
        return view("master.bus_station.delete", ["bus_station" => $bus_station]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, BusStation $bus_station)
    {
        $validated = $request->validate([
            "bus_station" => "required|numeric|exists:bus_stations,id"
        ]);

        $bus_station->delete();

        return redirect("/master/bus/station");
    }
}
