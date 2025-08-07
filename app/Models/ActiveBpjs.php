<?php

namespace App\Models;

use Illuminate\Support\Carbon;
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

    public function bpjsClass()
    {
        return $this->belongsTo(BpjsPrice::class, "class_id", "id");
    }

    public function isStillActive()
    {
        return $this->due_timestamp > now()->unix();
    }

    public function dueDate()
    {
        return Carbon::createFromTimestamp($this->due_timestamp);
    }

    public static function search(string $NIK)
    {
        $civilInformation = CivilInformation::where("NIK", "=", $NIK)->first();
        $bpjs = self::with("bpjsClass")
            ->where("civil_information_id", "=", $civilInformation->id)
            ->first();
        return $bpjs;
    }
}
