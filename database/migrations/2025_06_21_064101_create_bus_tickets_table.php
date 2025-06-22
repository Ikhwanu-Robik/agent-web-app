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
        Schema::create('bus_stations', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string("name");
        });

        Schema::create("bus_schedules", function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->date("departure_date");
            $table->time("departure_time");
            $table->integer("seats");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bus_stations');
        Schema::dropIfExists("bus_schedules");
    }
};
