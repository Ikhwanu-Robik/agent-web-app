<?php

namespace App\Models;

use Carbon\Carbon;
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
        $seats_structure = [];
        for ($row = 0; $row < $attributesRaw["seats_structure_height"]; $row++) {
            for ($col = 0; $col < $attributesRaw["seats_structure_width"]; $col++) {
                $seats_structure[$row][$col] = 0;
            }
        }

        $attributes = [
            "name" => $attributesRaw["name"],
            "seats_structure" => json_encode($seats_structure)
        ];
        Cinema::create($attributes);
    }

    public function updateSpecial(array $attributes)
    {
        $this->name = $attributes["name"];
        $new_seats_structure = [];
        for ($nRow = 0; $nRow < $attributes["seats_structure_height"]; $nRow++) {
            for ($nCol = 0; $nCol < $attributes["seats_structure_width"]; $nCol++) {
                $new_seats_structure[$nRow][$nCol] = 0;
            }
        }

        $this->seats_structure = json_encode($new_seats_structure);
        $this->save();
    }

    public static function findAiring(int $film_id)
    {
        $cinemas = self::with("films")->get();
        $searched_film = Film::find($film_id);

        $matching_cinemas = [];

        // foreach each cinema
        // and foreach the film they scheduled
        // if the film is the film we are looking for
        // mark the cinema as 'matching'
        foreach ($cinemas as $cinema) {
            foreach ($cinema->films as $film) {
                $isIdEqual = $film->film_schedule->film_id == $film_id;
                $isDateTodayOrTomorrow = Carbon::parse($film->film_schedule->airing_datetime)->gt(Carbon::now());

                $seats_status_array = json_decode($film->film_schedule->seats_status);
                $totalSeats = count($seats_status_array) * count($seats_status_array[0]);
                $filledSeats = 0;
                foreach ($seats_status_array as $row) {
                    foreach ($row as $col) {
                        if ($col == 1) {
                            $filledSeats++;
                        }
                    }
                }

                $isSeatsStillAvailable = $totalSeats != $filledSeats;

                if ($isIdEqual && $isDateTodayOrTomorrow && $isSeatsStillAvailable) {
                    array_push($matching_cinemas, $cinema);
                }
            }
        }

        // foreach each cinema
        // and foreach film they scheduled
        // if the film is the film we are looking for
        // put it in temporary array, $matchingFilms
        // then replace the cinema's films with the
        // temporary array
        // this is to ensure the matching_cinemas being
        // returned only with the requested film
        foreach ($matching_cinemas as $cinema) {
            $matchingFilms = [];

            foreach ($cinema->films as $film) {
                if ($film->title == $searched_film->title) {
                    array_push($matchingFilms, $film);
                }
            }

            $cinema->films = $matchingFilms;
        }

        return $matching_cinemas;
    }
}
