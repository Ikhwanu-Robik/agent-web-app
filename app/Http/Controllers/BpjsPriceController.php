<?php

namespace App\Http\Controllers;

use App\Models\BpjsPrice;
use Illuminate\Http\Request;

class BpjsPriceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bpjs_prices = BpjsPrice::all();

        return view("master.bpjs_price.bpjs_price", ["bpjs_prices" => $bpjs_prices]);
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

        BpjsPrice::create($validated);

        return redirect("/master/bus/station");
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BpjsPrice $bus_station)
    {
        return view("master.bus_station.edit", ["bus_station" => $bus_station]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BpjsPrice $bus_station)
    {
        $validated = $request->validate([
            "name" => "required|string"
        ]);

        $bus_station->name = $validated["name"];
        $bus_station->save();

        return redirect("/master/bus/station");
    }

    public function delete(BpjsPrice $bus_station) {
        return view("master.bus_station.delete", ["bus_station" => $bus_station]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, BpjsPrice $bus_station)
    {
        $validated = $request->validate([
            "bus_station" => "required|numeric|exists:bus_stations,id"
        ]);

        $bus_station->delete();

        return redirect("/master/bus/station");
    }
}
