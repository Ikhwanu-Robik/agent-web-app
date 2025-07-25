<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CinemaFilm extends Model
{
    protected $table = "cinema_film";

    protected $fillable = [
        "cinema_id",
        "film_id",
        "ticket_price",
        "airing_datetime",
        "seats_status"
    ];

    public function Cinema()
    {
        return $this->belongsTo(Cinema::class);
    }

    public function Film()
    {
        return $this->belongsTo(Film::class);
    }

    public function filmTicketTransaction()
    {
        return $this->hasMany(FilmTicketTransaction::class);
    }
}
