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
        Schema::create('game_topup_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->unsignedBigInteger('package_id');
            $table->string('flip_link_id')->unique()->nullable();
            $table->string('flip_link_url')->unique()->nullable();
            $table->string('method')->nullable();
            $table->string('status')->nullable();
            $table->integer("total");
            $table->timestamps();

            $table->foreign("package_id")->references("id")->on("game_topup_packages");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('game_topup_transactions');
    }
};
