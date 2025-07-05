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
        Schema::create('active_bpjs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("civil_information_id");
            $table->string("due_timestamp");
            $table->timestamps();

            $table->foreign("civil_information_id")->references("id")->on("civil_informations");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('active_bpjs');
    }
};
