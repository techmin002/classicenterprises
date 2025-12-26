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
        Schema::create('outsider_customers', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->unsignedBigInteger('branch_id')->nullable();
            $table->string('user_name')->nullable();
            $table->string('address')->nullable();
            $table->string('email')->nullable();
            $table->string('contact_no')->nullable();
            $table->string('landline')->nullable();
            $table->string('product_name')->nullable();
            $table->date('last_service_date')->nullable();
            $table->string('status');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('outsider_customers');
    }
};
