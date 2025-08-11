<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GameTopUpPackage extends Model
{
    protected $fillable = [
        'game_id',
        'title',
        'items_count',
        'price'
    ];

    public function game() {
        return $this->belongsTo(Game::class);
    }
}
