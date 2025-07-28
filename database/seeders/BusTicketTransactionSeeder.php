<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BusTicketTransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table("buses")->insert([
            "name" => "STJ Radaghas"
        ]);

        DB::table("bus_stations")->insert([
            "name" => "JKT"
        ]);

        DB::table("bus_stations")->insert([
            "name" => "BND"
        ]);

        $now = Carbon::now();
        $oneMonthFromNow = $now->addMonth();

        DB::table("bus_schedules")->insert([
            "bus_id" => 1,
            "origin_station_id" => 1,
            "destination_station_id" => 2,
            "departure_date" => $oneMonthFromNow->toDateString(),
            "departure_time" => now()->toTimeString(),
            "seats" => 30,
            "ticket_price" => 60000
        ]);
    }
}
