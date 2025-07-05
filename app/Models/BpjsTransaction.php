<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BpjsTransaction extends Model
{
    protected $table = "bpjs_transactions";

    protected $fillable = [
        "civil_information_id",
        "month_bought",
    ];

    public function civilInformation()
    {
        return $this->belongsTo(CivilInformation::class, "civil_information_id", "id");
    }
}
