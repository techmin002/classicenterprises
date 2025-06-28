<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('emi_customers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('emi_plan_id');
            $table->decimal('down_payment', 10, 2)->default(0);
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->decimal('monthly_pay', 10, 2);
            $table->string('document')->nullable();
            $table->boolean('status')->default(1); // 1 = Active, 0 = Inactive
            $table->timestamps();

            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->foreign('emi_plan_id')->references('id')->on('emi_plans')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('emi_customers');
    }
};
