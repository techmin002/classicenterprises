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
        Schema::create('customer_tickets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->unsignedBigInteger('amc_customer_id')->nullable();
            $table->string('user_name')->nullable();
            $table->string('customer_name')->nullable();
            $table->string('contact')->nullable();
            $table->string('landline')->nullable();
            $table->string('address')->nullable();
            $table->string('email')->nullable();
            $table->integer('branch_id');
            $table->date('install_date')->nullable();
            $table->string('type')->nullable();
            $table->string('support_type')->nullable();
            $table->string('service_type')->nullable();
            $table->string('priority')->nullable();
            $table->string('amc')->nullable();
            $table->string('warranty')->nullable();
            $table->string('assign_to')->nullable();
            $table->string('assign_to')->nullable();

            $table->decimal('service_charge', 10, 2)->nullable()->default(0);
            $table->decimal('amount', 10, 2)->nullable()->default(0);
            $table->decimal('total_amount', 10, 2)->nullable()->default(0);
            $table->decimal('paid_amount', 10, 2)->nullable()->default(0);
            $table->decimal('due_amount', 10, 2)->nullable()->default(0);
            $table->date('payment_date')->nullable();

            //Payment
            $table->enum('payment_status', ['unpaid', 'paid'])->default('unpaid')->nullable();
            $table->enum('payment_method', ['cash', 'online', 'cheque', 'multiple'])->nullable();
            $table->decimal('cash_amount', 10, 2)->nullable()->default(0);
            $table->string('cash_receipt')->nullable();

            $table->decimal('online_amount', 10, 2)->nullable()->default(0);
            $table->string('online_receipt')->nullable();

            $table->decimal('cheque_amount', 10, 2)->nullable()->default(0);
            $table->string('cheque_number')->nullable();
            $table->string('cheque_receipt')->nullable();
            $table->string('message')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_tickets');
    }
};
