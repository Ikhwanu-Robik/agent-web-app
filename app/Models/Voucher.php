<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    protected $fillable = [
        "off_percentage",
        "valid_for",
        "user_id"
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function createSpecial(array $attributes)
    {
        Voucher::create([
            "off_percentage" => $attributes["off_percentage"],
            "valid_for" => json_encode($attributes["valid_for"]),
            "user_id" => $attributes["user_id"]
        ]);
    }
}
