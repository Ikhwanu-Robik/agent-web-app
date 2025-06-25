<?php

namespace App\Models;

use App\Models\Bus;
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
}
