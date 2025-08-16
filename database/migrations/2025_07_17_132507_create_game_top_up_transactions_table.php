<?php

use App\Enums\TransactionStatus;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('game_top_up_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->unsignedBigInteger('package_id');
            $table->integer("total");
            $table->string('method')->nullable();
            $table->enum(
                'status',
                json_decode(
                    json_encode(TransactionStatus::cases())
                )
            )->default(TransactionStatus::PENDING->value);
            $table->string('flip_link_id')->unique()->nullable();
            $table->timestamps();

            $table->foreign("package_id")->references("id")->on("game_top_up_packages");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('game_top_up_transactions');
    }
};
