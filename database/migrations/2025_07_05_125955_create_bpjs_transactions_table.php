<?php

use App\Enums\TransactionStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bpjs_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId("user_id")->constrained("users");
            $table->unsignedBigInteger("civil_information_id");
            $table->integer("month_bought");
            $table->integer("total");
            $table->string("method");
            $table->enum(
                "status",
                json_decode(
                    json_encode(TransactionStatus::cases())
                )
            )->default(TransactionStatus::PENDING->value);
            $table->string("flip_link_id")->unique()->nullable();
            $table->timestamps();

            $table->foreign("civil_information_id")->references("id")->on("civil_informations");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bpjs_transactions');
    }
};
