<?php

namespace App\Models;

use App\Models\Film;
use Illuminate\Database\Eloquent\Model;

class Cinema extends Model
{
    protected $table = "cinemas";

    protected $fillable = [
        "name",
        "seats_structure",
    ];

    public function Films()
    {
        return $this->belongsToMany(Film::class)
            ->as("film_schedule")
            ->withPivot(["id", "film_id", "ticket_price", "airing_datetime", "seats_status"]);
    }

    public static function createSpecial(array $attributesRaw)
    {
        $seatsStructure = [];
        for ($row = 0; $row < $attributesRaw["seats_structure_height"]; $row++) {
            for ($col = 0; $col < $attributesRaw["seats_structure_width"]; $col++) {
                $seatsStructure[$row][$col] = 0;
            }
        }

        $attributes = [
            "name" => $attributesRaw["name"],
            "seats_structure" => json_encode($seatsStructure)
        ];
        Cinema::create($attributes);
    }

    public function updateSpecial(array $attributes)
    {
        $this->name = $attributes["name"];
        $newSeatsStructure = [];
        for ($nRow = 0; $nRow < $attributes["seats_structure_height"]; $nRow++) {
            for ($nCol = 0; $nCol < $attributes["seats_structure_width"]; $nCol++) {
                $newSeatsStructure[$nRow][$nCol] = 0;
            }
        }

        $this->seats_structure = json_encode($newSeatsStructure);
        $this->save();
    }

    public static function findAiring(int $film_id)
    {
        $schedules = self::where("cinema_film.film_id", "=", $film_id)
            ->join("cinema_film", "cinema_film.cinema_id", "=", "cinemas.id")
            ->join("films", "cinema_film.film_id", "=", "films.id")
            ->get([
                "cinema_film.id",
                "cinema_film.cinema_id",
                "cinema_film.ticket_price",
                "cinema_film.airing_datetime",
                "cinema_film.seats_status",
                "films.id AS film_id",
                "films.title",
                "films.poster_image_url",
                "films.release_date",
                "films.duration"
            ]);

        $cinemas = self::get();

        foreach ($cinemas as $cinema) {
            $matchingSchedules = [];

            foreach ($schedules as $schedule) {
                if ($cinema->id == $schedule->cinema_id) {
                    array_push($matchingSchedules, $schedule);
                }
            }

            $cinema->schedules = $matchingSchedules;
        }

        return $cinemas;
    }
}
