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
        Schema::create('petty_cash_adds', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->decimal('amount', 10, 2)->default(0);
            $table->string('date');
            $table->string('month');
            $table->decimal('lm_remaining_cash', 10, 2)->default(0);
            $table->decimal('remaining_cash', 10, 2)->default(0);
            $table->decimal('total_amount', 10, 2)->default(0);
            $table->string('slug');
            $table->string('branch_id')->nullable();
            $table->string('created_by')->nullable();
            $table->string('status')->default('on');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('petty_cash_adds');
    }
};
