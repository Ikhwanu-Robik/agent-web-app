<?php

namespace App\Http\Controllers\resources;

use App\Models\Bus;
use App\Models\BusStation;
use App\Models\BusSchedule;
use App\Http\Requests\StoreBusScheduleRequest;
use App\Http\Requests\UpdateBusScheduleRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BusScheduleController extends Controller
{
    public function index()
    {
        return view("master.bus_schedule.bus_schedule", ["bus_schedules" => BusSchedule::all()]);
    }

    public function create()
    {
        $buses = Bus::all();
        $stations = BusStation::all();

        return view("master.bus_schedule.create", ["buses" => $buses, "bus_stations" => $stations]);
    }

    public function store(StoreBusScheduleRequest $storeBusScheduleRequest)
    {
        BusSchedule::create($storeBusScheduleRequest->validated());

        return redirect("/master/bus/schedules");
    }

    public function edit(BusSchedule $schedule)
    {
        $buses = Bus::all();
        $stations = BusStation::all();

        return view("master.bus_schedule.edit", ["schedule" => $schedule, "buses" => $buses, "bus_stations" => $stations]);
    }

    public function update(UpdateBusScheduleRequest $updateBusScheduleRequest, BusSchedule $schedule)
    {
        $validated = $updateBusScheduleRequest->validated();

        $schedule->bus_id = $validated["bus_id"];
        $schedule->origin_station_id = $validated["origin_station_id"];
        $schedule->destination_station_id = $validated["destination_station_id"];
        $schedule->departure_date = $validated["departure_date"];
        $schedule->departure_time = $validated["departure_time"];
        $schedule->seats = $validated["seats"];
        $schedule->ticket_price = $validated["ticket_price"];

        $schedule->save();

        return redirect("/master/bus/schedules");
    }

    public function delete(BusSchedule $schedule)
    {
        return view("master.bus_schedule.delete", ["schedule" => $schedule]);
    }

    public function destroy(Request $request, BusSchedule $schedule)
    {
        $schedule->delete();

        return redirect("/master/bus/schedules");
    }
}
