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
        Schema::create('payment_verifications', function (Blueprint $table) {
            $table->id();
            $table->string('customer_id')->nullable();
            $table->string('lead_id')->nullable();
            $table->string('branch_id');
            $table->integer('total_amount');
            $table->integer('paid_amount');
            $table->integer('remaining_amount');
            $table->string('payment_method')->nullable();
            $table->date('payment_date')->nullable();
            $table->string('status')->default('on');
            $table->string('message')->nullable();
            $table->string('receipt')->nullable();
            $table->string('created_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_verifications');
    }
};
