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
        Schema::create('amc_accessories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('amc_id');
            $table->unsignedBigInteger('accessory_id');
            $table->integer('quantity');
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('amc_id')->references('id')->on('amcs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('amc_accessories');
    }
};
