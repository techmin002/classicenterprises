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
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('branch_id')->nullable(); 
            $table->string('created_by')->nullable();
            $table->string('name');
            $table->string('type')->nullable(); // Default type is 'local'
            $table->string('contact'); 
            $table->string('email'); 
            $table->string('address');
            $table->string('PAN');
            $table->string('VAT')->nullable();
            $table->string('discription')->nullable(); 
            $table->string('status')->default('active'); // Default status is 'active'
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suppliers');
    }
};
