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
        Schema::create('task_service_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('task_id');  // Foreign key to tasks table
            $table->string('name');
            $table->integer('qty');
            $table->decimal('price', 10, 2);
            $table->timestamps();
            $table->foreign('task_id')->references('id')->on('tasks')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('task_service_items');
    }
};
