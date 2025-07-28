<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PowerTransaction extends Model
{
    protected $fillable = [
        "user_id",
        "subscriber_number",
        "total",
        "method",
        "status",
        "flip_link_id"
    ];
}