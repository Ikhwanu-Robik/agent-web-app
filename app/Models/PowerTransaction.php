<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PowerTransaction extends Model
{
    protected $fillable = [
        "subscriber_number",
        "total",
        "method",
        "status"
    ];
}