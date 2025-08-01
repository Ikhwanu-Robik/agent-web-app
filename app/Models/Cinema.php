<?php

namespace App\Models;

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
}
