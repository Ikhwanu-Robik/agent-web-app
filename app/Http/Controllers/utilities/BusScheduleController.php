<?php

namespace App\Http\Controllers\utilities;

use Carbon\Carbon;
use App\Models\BusSchedule;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BusScheduleController extends Controller
{
    public function search(Request $request)
    {
        $validated = $request->validate([
            "origin" => "required|exists:bus_stations,id",
            "destination" => "required|exists:bus_stations,id",
            "ticket_amount" => "required|numeric"
        ]);

        $query = BusSchedule::where("departure_date", ">=", Carbon::now())
            ->where("origin_station_id", "=", $validated["origin"])
            ->where("destination_station_id", "=", $validated["destination"])
            ->where("seats", ">=", $validated["ticket_amount"]);

        $matching_schedules = $query
            ->get();

        return back()->with("matching_schedules", $matching_schedules)->with("redirect_status", "successful redirection")->withInput();
    }
}
