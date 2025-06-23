<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create("buses", function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string("name");
        });

        Schema::create('bus_stations', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string("name");
        });

        Schema::create("bus_schedules", function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger("bus_id");
            $table->unsignedBigInteger("origin_station_id");
            $table->unsignedBigInteger("destination_station_id");
            $table->date("departure_date");
            $table->time("departure_time");
            $table->integer("seats");
            $table->integer("ticket_price");

            $table->foreign("bus_id")->references("id")->on("buses");
            $table->foreign("origin_station_id")->references("id")->on("bus_stations");
            $table->foreign("destination_station_id")->references("id")->on("bus_stations");
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("buses");
        Schema::dropIfExists('bus_stations');
        Schema::dropIfExists("bus_schedules");
    }
};
