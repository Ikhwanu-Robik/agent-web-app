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
        Schema::create('film_ticket_transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("cinema_film_id");
            $table->string("seats_coordinates");
            $table->integer("total");
            $table->timestamps();

            $table->foreign("cinema_film_id")->references("id")->on("cinema_film");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('film_ticket_transactions');
    }
};
