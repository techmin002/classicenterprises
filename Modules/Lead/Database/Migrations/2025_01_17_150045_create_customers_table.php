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
        Schema::create('customers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('lead_id')->nullable();
            $table->integer('branch_id');
            $table->integer('created_by')->nullable();
            $table->integer('converted_by')->nullable();
            $table->string('user_name')->nullable();
            $table->integer('exchange_amount')->nullable()->default(0);
            $table->integer('total_amount')->nullable()->default(0);
            $table->integer('paid_amount')->nullable()->default(0);
            $table->integer('due_amount')->nullable()->default(0);
            $table->string('amc')->default('no');
            $table->string('amc_date')->nullable();
            $table->string('ticket_status')->nullable();

            // 🧾 Payment Details
            $table->enum('payment_status', ['unpaid', 'paid'])->default('unpaid');
            $table->enum('payment_method', ['cash', 'online', 'cheque', 'multiple'])->nullable();

            // 💰 Individual Payment Type Fields
            $table->decimal('cash_amount', 10, 2)->nullable()->default(0);
            $table->string('cash_receipt')->nullable();

            $table->decimal('online_amount', 10, 2)->nullable()->default(0);
            $table->string('online_receipt')->nullable();

            $table->decimal('cheque_amount', 10, 2)->nullable()->default(0);
            $table->string('cheque_number')->nullable();
            $table->string('cheque_receipt')->nullable();

            $table->boolean('gifted')->default(0);
            $table->string('customer_type')->nullable();
            $table->string('sales_type')->nullable();
            $table->string('installation_category')->nullable();
            $table->timestamp('install_date')->nullable();
            $table->string('status')->nullable();
            $table->unsignedBigInteger('assign_to')->nullable();
            $table->text('message')->nullable();
            $table->date('warranty_in')->nullable();
            $table->date('warranty_out')->nullable();
            $table->date('warranty__service_date')->nullable();
            $table->boolean('warranty_lifetime')->default(0);
            $table->string('product_document')->nullable();
            $table->string('warranty_card')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
