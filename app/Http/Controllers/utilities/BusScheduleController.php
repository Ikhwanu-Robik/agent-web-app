<?php

namespace App\Http\Controllers\utilities;

use App\Models\BusSchedule;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BusScheduleController extends Controller
{
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
