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
        Schema::create('customer_ticket_accessories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('ticket_id');
            $table->integer('branch_id');
            $table->integer('accessory_id');
            $table->integer('customer_id')->nullable();
            $table->integer('created_by');
            $table->integer('accessory_qty');
            $table->integer('accessory_price');
            $table->integer('accessory_total');
            $table->string('status')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_ticket_accessories');
    }
};
