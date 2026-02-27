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
       Schema::create('staff_item_returns', function (Blueprint $table) {
    $table->id();

    $table->unsignedBigInteger('assignment_id');

    $table->integer('returned_qty')->default(0);
    $table->integer('used_qty')->default(0);
    $table->integer('broken_qty')->default(0);

    $table->unsignedBigInteger('verified_by')->nullable();
    $table->timestamp('verified_at')->nullable();

    $table->text('remarks')->nullable();

    $table->timestamps();

    // Foreign Keys
    $table->foreign('assignment_id')
          ->references('id')
          ->on('staff_item_assignments')
          ->onDelete('cascade');

    $table->foreign('verified_by')
          ->references('id')
          ->on('users')
          ->onDelete('set null');
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff_item_returns');
    }
};
