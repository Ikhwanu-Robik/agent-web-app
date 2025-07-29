<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class FilmTicketTransaction extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $seats_structure = json_encode([
            [0, 0, 0, 0, 0, 0, 0],
            [0, 0, 0, 0, 0, 0, 0],
            [0, 0, 0, 0, 0, 0, 0],
            [0, 0, 0, 0, 0, 0, 0]
        ]);

        DB::table("cinemas")->insert([
            "name" => "Citra Media XII",
            "seats_structure" => $seats_structure
        ]);

        DB::table("films")->insert([
            "title" => "Frozen",
            "poster_image_url" => "some_image.png",
            "release_date" => now()->addMonths(2)->toDateString(),
            "duration" => 130
        ]);

        $seats_status = json_encode([
            [0, 0, 0, 0, 0, 0, 0],
            [0, 0, 0, 0, 0, 0, 0],
            [0, 0, 0, 0, 0, 0, 0],
            [0, 0, 0, 0, 0, 0, 0]
        ]);

        DB::table("cinema_film")->insert([
            "cinema_id" => 1,
            "film_id" => 1,
            "ticket_price" => 80000,
            "airing_datetime" => now()->addWeeks(2)->toDateTimeString(),
            "seats_status" => $seats_status
        ]);
    }
}
