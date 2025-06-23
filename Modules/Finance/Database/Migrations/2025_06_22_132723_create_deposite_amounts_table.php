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
        Schema::create('deposite_amounts', function (Blueprint $table) {
            $table->id();
            $table->decimal('amount', 10, 2);
            $table->string('bank_name');
            $table->string('image')->nullable();
            $table->date('date');
            $table->string('status')->default('deposited');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deposite_amounts');
    }
};
