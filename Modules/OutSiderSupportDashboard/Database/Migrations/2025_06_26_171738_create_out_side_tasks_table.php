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
        Schema::create('out_side_tasks', function (Blueprint $table) {
            $table->id();
            $table->string('customer_id')->nullable();
            $table->string('name');
            $table->string('branch_id')->nullable();
            $table->string('product');
            $table->string('contact');
            $table->string('email');
            $table->string('date');
            $table->string('support_type');
            $table->string('service_type')->nullable();
            $table->string('priority');
            $table->string('assign_to')->nullable();
            $table->text('address')->nullable();
$table->text('home_address')->nullable();
            $table->string('payment_method')->nullable();
            $table->decimal('service_charge', 10, 2)->default(0);
            $table->decimal('amount', 10, 2)->default(0);
            $table->decimal('paid_amount', 10, 2)->default(0);
            $table->string('message');
            $table->string('status')->default('create');
            $table->string('created_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('out_side_tasks');
    }
};
