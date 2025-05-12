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
        Schema::create('customer_payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('lead_id');
            $table->integer('branch_id');
            $table->integer('customer_id');
            $table->integer('created_by');
            $table->integer('paid_amount');
            $table->string('receipt')->nullable();
            $table->string('payment_method')->nullable();
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
        Schema::dropIfExists('customer_payments');
    }
};
