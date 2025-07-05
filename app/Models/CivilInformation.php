<?php

namespace App\Models;

use App\Models\ActiveBpjs;
use Illuminate\Database\Eloquent\Model;

class CivilInformation extends Model
{
    protected $table = "civil_informations";

    protected $fillable = [
        "NIK",
    ];

    public function activeBpjs() {
        return $this->hasOne(ActiveBpjs::class, "civil_information_id", "id");
    }
}
