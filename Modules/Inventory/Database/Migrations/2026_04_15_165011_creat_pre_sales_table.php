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
       Schema::create('pre_sales', function (Blueprint $table) {
    $table->id();
    $table->string('booking_number')->unique();
    $table->string('customer_name');
    $table->string('contact')->nullable();
    $table->string('email')->nullable();
    $table->text('address')->nullable();

    $table->decimal('total_amount', 10, 2)->default(0);
    $table->decimal('advance_amount', 10, 2)->default(0);
    $table->decimal('balance_due', 10, 2)->default(0);

    $table->enum('status', ['pending', 'confirmed', 'cancelled'])->default('pending');

    $table->unsignedBigInteger('branch_id')->nullable();
    $table->unsignedBigInteger('created_by');

    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
