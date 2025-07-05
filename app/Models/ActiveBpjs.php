<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActiveBpjs extends Model
{
    protected $table = "active_bpjs";

    protected $fillable = [
        "civil_information_id",
        "due_timestamp"
    ];

    public function civilInformation()
    {
        return $this->belongsTo(CivilInformation::class, "civil_information_id", "id");
    }
}
