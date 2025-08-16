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
        Schema::create('power_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId("user_id")->constrained("users");
            $table->string("subscriber_number");
            $table->double("total");
            $table->string("method");
            $table->enum(
                'status',
                json_decode(
                    json_encode(TransactionStatus::cases())
                )
            )->default(TransactionStatus::PENDING->value);
            $table->string("flip_link_id")->unique()->nullable();
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
