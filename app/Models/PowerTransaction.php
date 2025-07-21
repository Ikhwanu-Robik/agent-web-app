<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PowerTransaction extends Model
{
    protected $fillable = [
        "power_subscriber_id",
        "kWh_usage",
        "total"
    ];
}