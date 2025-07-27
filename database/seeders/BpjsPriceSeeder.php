<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BpjsPriceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table("bpjs_prices")->insert([
            "class" => "1",
            "price" => "35000",
        ]);

        DB::table("bpjs_prices")->insert([
            "class" => "2",
            "price" => "40000",
        ]);

        DB::table("bpjs_prices")->insert([
            "class" => "3",
            "price" => "100000",
        ]);
    }
}
