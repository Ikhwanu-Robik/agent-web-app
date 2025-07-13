<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Film extends Model
{
    protected $table = "films";

    protected $fillable = [
        "title",
        "poster_image_url",
        "release_date",
        "duration"
    ];

    public function Cinemas() {
        return $this->belongsToMany(Cinema::class)
            ->as("film_schedule")
            ->withPivot(["id", "ticket_price", "airing_datetime"]);
    }
}
