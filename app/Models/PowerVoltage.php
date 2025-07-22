<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PowerVoltage extends Model
{
    protected $fillable = [
        "volts",
        "price_per_kWh"
    ];
}
