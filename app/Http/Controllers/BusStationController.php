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
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(vc $vc)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(vc $vc)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, vc $vc)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(vc $vc)
    {
        //
    }
}
