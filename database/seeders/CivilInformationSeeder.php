<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CivilInformationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table("civil_informations")->insert([
            "NIK" => "33120001",
        ]);

        DB::table("civil_informations")->insert([
            "NIK" => "33120002",
        ]);

        DB::table("civil_informations")->insert([
            "NIK" => "33120003",
        ]);
    }
}
