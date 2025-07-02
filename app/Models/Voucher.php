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
}
