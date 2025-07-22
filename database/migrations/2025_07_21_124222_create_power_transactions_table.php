<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('power_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId("power_subscriber_id")->constrained("power_subscribers");
            $table->double("total");
            $table->string("method");
            $table->string("status");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('power_transactions');
    }
};
