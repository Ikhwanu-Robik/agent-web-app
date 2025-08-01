<?php

namespace App\Http\Controllers\resources;

use App\Models\BusStation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBusStationRequest;
use App\Http\Requests\UpdateBusStationRequest;

class BusStationController extends Controller
{
    public function index()
    {
        $bus_stations = BusStation::all();

        return view("master.bus_station.bus_station", ["bus_stations" => $bus_stations]);
    }

    public function create()
    {
        return view("master.bus_station.create");
    }

    public function store(StoreBusStationRequest $storeBusStationRequest)
    {
        BusStation::create($storeBusStationRequest->validated());

        return redirect("/master/bus/station");
    }

    public function edit(BusStation $bus_station)
    {
        return view("master.bus_station.edit", ["bus_station" => $bus_station]);
    }

    public function update(UpdateBusStationRequest $updateBusStationRequest, BusStation $bus_station)
    {
        $bus_station->update($updateBusStationRequest->validated());

        return redirect("/master/bus/station");
    }

    public function delete(BusStation $bus_station) {
        return view("master.bus_station.delete", ["bus_station" => $bus_station]);
    }

    public function destroy(Request $request, BusStation $bus_station)
    {
        $bus_station->delete();

        return redirect("/master/bus/station");
    }
}
