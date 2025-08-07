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
        $busStations = BusStation::all();

        return view("master.bus-station.bus-station", ["busStations" => $busStations]);
    }

    public function create()
    {
        return view("master.bus-station.create");
    }

    public function store(StoreBusStationRequest $storeBusStationRequest)
    {
        BusStation::create($storeBusStationRequest->validated());

        return redirect("/master/bus/station");
    }

    public function edit(BusStation $busStation)
    {
        return view("master.bus-station.edit", ["busStation" => $busStation]);
    }

    public function update(UpdateBusStationRequest $updateBusStationRequest, BusStation $busStation)
    {
        $busStation->update($updateBusStationRequest->validated());

        return redirect("/master/bus/station");
    }

    public function delete(BusStation $busStation) {
        return view("master.bus-station.delete", ["busStation" => $busStation]);
    }

    public function destroy(Request $request, BusStation $busStation)
    {
        $busStation->delete();

        return redirect("/master/bus/station");
    }
}
