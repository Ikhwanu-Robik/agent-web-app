<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class GameTopUpTransaction extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table("games")->insert([
            "name" => "Arkek",
            "icon" => "some_image.png",
            "currency" => "Originite Prime"
        ]);

        DB::table("game_top_up_packages")->insert([
            "game_id" => 1,
            "title" => "5th Anniversery Offer",
            "items_count" => 70,
            "price" => 120000
        ]);
    }
}
