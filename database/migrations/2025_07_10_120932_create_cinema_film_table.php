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
        Schema::create('cinema_film', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("cinema_id");
            $table->unsignedBigInteger("film_id");
            $table->integer("ticket_price");
            $table->dateTime("airing_datetime");
            $table->timestamps();

            $table->foreign("cinema_id")->references("id")->on("cinemas");
            $table->foreign("film_id")->references("id")->on("films");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cinema_film');
    }
};
