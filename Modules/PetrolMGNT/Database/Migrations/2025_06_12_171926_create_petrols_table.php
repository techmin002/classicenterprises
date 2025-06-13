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
        Schema::create('petrols', function (Blueprint $table) {
            $table->id();
            $table->string('bike_id')->nullable();
            $table->decimal('amount', 10, 2)->default(0);
            $table->string('date');
            $table->string('km');
            $table->string('message');
            $table->string('created_by')->nullable();
            $table->string('status')->default('on');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('petrols');
    }
};
