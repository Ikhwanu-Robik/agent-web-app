<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BusTicketTransaction extends Model
{
    protected $fillable = [
        "user_id",
        "bus_schedule_id",
        "ticket_amount",
        "total",
        "status",
    ];

    public function busSchedule() {
        return $this->belongsTo(BusSchedule::class);
    }
}
