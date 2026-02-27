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
       Schema::create('staff_item_assignments', function (Blueprint $table) {
    $table->id();

    $table->unsignedBigInteger('staff_id');
    $table->unsignedBigInteger('branch_id');

    $table->enum('item_type', ['accessory', 'technical_tool']);
    $table->unsignedBigInteger('item_id');

    $table->integer('assigned_qty')->default(1);

    $table->unsignedBigInteger('assigned_by')->nullable();
    $table->timestamp('assigned_at')->nullable();

    $table->enum('status', ['assigned', 'returned', 'verified'])->default('assigned');
    $table->text('remarks')->nullable();

    $table->timestamps();

    // Foreign Keys
    $table->foreign('staff_id')->references('id')->on('users')->onDelete('cascade');
    $table->foreign('assigned_by')->references('id')->on('users')->onDelete('set null');
    $table->foreign('branch_id')->references('id')->on('branches')->onDelete('cascade');
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff_item_assignments');
    }
};
