<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GameTopUpTransaction extends Model
{
    protected $table = "game_topup_transactions";

    protected $fillable = [
        'user_id',
        'package_id',
        'flip_link_id',
        'flip_link_url',
        'method',
        'status',
        'total'
    ];

    public function topUpPackage() {
        return $this->belongsTo(GameTopUpPackage::class, "package_id", "id");
    }
}
