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
        Schema::create('amc_customers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->unsignedBigInteger('amc_id');
            $table->integer('branch_id');
            $table->string('customer_name')->nullable();
            $table->string('contact')->unique()->nullable();
             $table->string('contact')->unique()->nullable();
            $table->string('address')->nullable();
            $table->string('type');
            $table->string('image')->nullable();
            $table->date('date')->nullable();
            $table->date('last_date')->nullable();
            $table->string('amount')->nullable();
            //Payment
            $table->enum('payment_status', ['unpaid', 'paid'])->default('unpaid');
            $table->enum('payment_method', ['cash', 'online', 'cheque', 'multiple'])->nullable();
            $table->decimal('cash_amount', 10, 2)->nullable()->default(0);
            $table->string('cash_receipt')->nullable();

            $table->decimal('online_amount', 10, 2)->nullable()->default(0);
            $table->string('online_receipt')->nullable();

            $table->decimal('cheque_amount', 10, 2)->nullable()->default(0);
            $table->string('cheque_number')->nullable();
            $table->string('cheque_receipt')->nullable();
            $table->string('message');
            $table->string('status')->nullable();
            $table->timestamps();

            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->foreign('amc_id')->references('id')->on('amcs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('amc_customers');
    }
};
