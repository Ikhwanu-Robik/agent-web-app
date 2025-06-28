<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BusTicketTransaction extends Model
{
    protected $fillable = [
        "bus_schedule_id",
        "ticket_amount"
    ];

    public function busSchedule() {
        return $this->belongsTo(BusSchedule::class);
    }
}
