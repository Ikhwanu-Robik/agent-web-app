<?php

namespace App\Http\Controllers;

use App\Models\Bus;
use App\Models\BusStation;
use App\Models\BusSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BusScheduleController extends Controller
{
    // Admin functions
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

    public function store(Request $request)
    {
        $validated = $request->validate([
            "bus_id" => "required|exists:buses,id",
            "origin_station_id" => "required|exists:bus_stations,id",
            "destination_station_id" => "required|exists:bus_stations,id|different:origin_station_id",
            "departure_date" => "required|date",
            "departure_time" => "required", // I should add further validation, but I can only think of using Regex
            "seats" => "required|numeric",
            "ticket_price" => "required|numeric"
        ]);
        // I need to validate that all record is unique
        // Two records may have the same departure_date and/or departure_time IF
        // Their bus is different

        BusSchedule::create($validated);

        return redirect("/master/bus/schedules");
    }

    public function edit(BusSchedule $schedule)
    {
        $buses = Bus::all();
        $stations = BusStation::all();

        return view("master.bus_schedule.edit", ["schedule" => $schedule, "buses" => $buses, "bus_stations" => $stations]);
    }

    public function update(Request $request, BusSchedule $schedule)
    {
        $validated = $request->validate([
            "bus_id" => "required|exists:buses,id",
            "origin_station_id" => "required|exists:bus_stations,id",
            "destination_station_id" => "required|exists:bus_stations,id|different:origin_station_id",
            "departure_date" => "required|date",
            "departure_time" => "required", // I should add further validation, but I can only think of using Regex
            "seats" => "required|numeric",
            "ticket_price" => "required|numeric"
        ]);

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
        $validated = $request->validate([
            "schedule" => "required|numeric|exists:bus_schedules,id"
        ]);

        $schedule->delete();

        return redirect("/master/bus/schedules");
    }

    // Agent functions
    public function search(Request $request)
    {
        $validated = $request->validate([
            "departure_date" => "required|date",
            "origin" => "required|exists:bus_stations,id",
            "destination" => "required|exists:bus_stations,id",
            "ticket_amount" => "required|numeric"
        ]);

        $query = BusSchedule::where("departure_date", "=", $validated["departure_date"])
            ->where("origin_station_id", "=", $validated["origin"])
            ->where("destination_station_id", "=", $validated["destination"])
            ->where("seats", ">=", $validated["ticket_amount"]);

        $matching_schedules = $query
            ->get();

        return back()->with("matching_schedules", $matching_schedules)->with("redirect_status", "successful redirection")->withInput();
    }
}
