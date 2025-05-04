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
            $table->integer('lead_id');
            $table->integer('branch_id');
            $table->integer('created_by');
            $table->integer('converted_by')->nullable();
            $table->string('user_name')->nullable();
            $table->integer('total_amount')->nullable();
            $table->integer('paid_amount')->nullable();
            $table->integer('due_amount')->nullable();
            $table->string('customer_type')->nullable();
            $table->string('sales_type')->default('classic_customer');
            $table->timestamp('install_date')->nullable();
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
        Schema::dropIfExists('customers');
    }
};
