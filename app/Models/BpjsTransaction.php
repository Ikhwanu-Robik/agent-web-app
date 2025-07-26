<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BpjsTransaction extends Model
{
    protected $table = "bpjs_transactions";

    protected $fillable = [
        "user_id",
        "civil_information_id",
        "month_bought",
        "total",
        "method"
    ];

    public function civilInformation()
    {
        return $this->belongsTo(CivilInformation::class, "civil_information_id", "id");
    }
}
