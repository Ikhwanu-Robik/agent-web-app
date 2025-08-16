<?php

namespace App\Models;

use App\Models\Bus;
use App\Models\BusStation;
use Illuminate\Database\Eloquent\Model;

class BusSchedule extends Model
{
    protected $fillable = [
        "bus_id",
        "origin_station_id",
        "destination_station_id",
        "departure_date",
        "departure_time",
        "seats",
        "ticket_price"
    ];

    public function bus() {
        return $this->belongsTo(Bus::class, "bus_id");
    }

    public function originStation() {
        return $this->belongsTo(BusStation::class, "origin_station_id");
    }

    public function destinationStation() {
        return $this->belongsTo(BusStation::class, "destination_station_id");
    }

    public static function search(array $validated)
    {
        $query = self::where("departure_date", ">=", $validated["departure_date"])
            ->where("departure_time", ">=", $validated["departure_time"])
            ->where("origin_station_id", "=", $validated["origin"])
            ->where("destination_station_id", "=", $validated["destination"])
            ->where("seats", ">=", $validated["ticket_amount"]);

        return $query->get();
    }

    public function reduceAvailableTicket(int $reduction_amount)
    {
        $this->seats = $this->seats - $reduction_amount;
        $this->save();
    }
}
