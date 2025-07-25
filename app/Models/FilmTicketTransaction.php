<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FilmTicketTransaction extends Model
{
    protected $table = "film_ticket_transactions";

    protected $fillable = [
        "cinema_film_id",
        "seats_coordinates",
        "status",
        "total"
    ];

    public function CinemaFilm()
    {
        return $this->belongsTo(CinemaFilm::class);
    }
}
