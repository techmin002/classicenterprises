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
        Schema::create('inventory_transactions', function (Blueprint $table) {
    $table->id();

    $table->unsignedBigInteger('branch_id');

    $table->enum('item_type', ['accessory', 'technical_tool']);
    $table->unsignedBigInteger('item_id');

    $table->integer('qty'); // always positive

    $table->enum('transaction_type', ['used', 'broken']);
    $table->enum('source', ['staff_assignment']);

    $table->unsignedBigInteger('reference_id'); // staff_item_returns.id

    $table->timestamps();

    // Foreign Keys
    $table->foreign('branch_id')
          ->references('id')
          ->on('branches')
          ->onDelete('cascade');
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_transactions');
    }
};
