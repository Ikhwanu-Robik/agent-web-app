<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PowerSubscriber extends Model
{
    protected $fillable = [
        "subscriber_number",
        "power_voltage_id",
    ];

    public function powerVoltage()
    {
        return $this->belongsTo(PowerVoltage::class);
    }
}
