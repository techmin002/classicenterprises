<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('emi_payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('emi_customers_id'); // foreign key to emi_customers
            $table->unsignedBigInteger('customer_id'); // foreign key to customers
            $table->decimal('payment', 10, 2);
            $table->string('payment_method');
            $table->date('date');
            $table->string('receipt')->nullable();
            $table->text('message')->nullable();
            $table->enum('status', ['pending', 'paid', 'failed'])->default('pending');
            $table->timestamps();

            // Optional: Add foreign key constraints
            $table->foreign('emi_customers_id')->references('id')->on('emi_customers')->onDelete('cascade');
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('emi_payments');
    }
};
