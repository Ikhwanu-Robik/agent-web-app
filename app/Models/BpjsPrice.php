<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BpjsPrice extends Model
{
    protected $table = "bpjs_prices";

    protected $fillable = [
        "class",
        "prices"
    ];
}
