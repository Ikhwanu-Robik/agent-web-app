<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ActiveBpjsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table("active_bpjs")->insert([
            "civil_information_id" => 1,
            "class_id" => 1,
            "due_timestamp" => now()->unix() + 18144000
        ]);

        DB::table("active_bpjs")->insert([
            "civil_information_id" => 2,
            "class_id" => 2,
            "due_timestamp" => now()->unix() + 2 * 18144000
        ]);

        DB::table("active_bpjs")->insert([
            "civil_information_id" => 3,
            "class_id" => 3,
            "due_timestamp" => now()->unix() + 3 * 18144000
        ]);
    }
}
