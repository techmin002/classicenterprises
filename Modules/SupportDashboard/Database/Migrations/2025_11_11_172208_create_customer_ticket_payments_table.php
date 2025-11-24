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
        Schema::create('customer_ticket_payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('ticket_id');
            $table->integer('branch_id');
            $table->integer('customer_id')->nullable();
            $table->integer('created_by');
            $table->integer('paid_amount');
            $table->string('payment_method')->nullable();
            $table->integer('cash_amount')->nullable();
            $table->string('cash_receipt')->nullable();
            $table->integer('online_amount')->nullable();
            $table->string('online_receipt')->nullable();
            $table->integer('cheque_amount')->nullable();
            $table->string('cheque_number')->nullable();
            $table->string('cheque_receipt')->nullable();
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
        Schema::dropIfExists('customer_ticket_payments');
    }
};
