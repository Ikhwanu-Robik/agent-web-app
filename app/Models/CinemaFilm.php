<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Models\Cinema;

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

    public static function createSpecial(array $attributesRaw, Cinema $cinema)
    {
        $attributes = [
            "cinema_id" => $cinema->id,
            "film_id" => $attributesRaw["film"],
            "ticket_price" => $attributesRaw["ticket_price"],
            "airing_datetime" => Carbon::make($attributesRaw["datetime_airing"]),
            "seats_status" => $cinema->seats_structure
        ];
        CinemaFilm::create($attributes);
    }

    public function updateAvailableSeats(array $bookedSeatsCoordinates)
    {
        $newSeats = json_decode($this->seats_status);

        foreach ($bookedSeatsCoordinates as $seatCoord) {
            $col = explode(",", $seatCoord)[0];
            $row = explode(",", $seatCoord)[1];

            $newSeats[$row][$col] = 1;
        }

        $this->seats_status = json_encode($newSeats);
        $this->save();
    }
}
