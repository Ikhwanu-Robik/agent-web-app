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
        Schema::create('power_subscribers', function (Blueprint $table) {
            $table->id();
            $table->string("subscriber_number");
            $table->foreignId("power_voltage_id")->constrained("power_voltages");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('power_subscribers');
    }
};
