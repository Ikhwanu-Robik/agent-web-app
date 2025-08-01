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
}
