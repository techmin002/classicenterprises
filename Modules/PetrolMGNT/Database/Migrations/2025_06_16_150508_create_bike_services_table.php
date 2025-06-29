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
        Schema::create('bike_services', function (Blueprint $table) {
            $table->id();
            $table->string('bike_id')->nullable();
            $table->string('branch_id')->nullable();
            $table->decimal('amount', 10, 2)->default(0);
            $table->string('date');
            $table->string('mode');
            $table->string('image')->nullable();
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
        Schema::dropIfExists('bike_services');
    }
};
