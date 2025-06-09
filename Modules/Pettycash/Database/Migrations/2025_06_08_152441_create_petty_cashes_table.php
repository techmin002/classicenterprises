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
        Schema::create('petty_cashes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->string('amount');
            $table->string('date');
            $table->string('month');
            $table->string('remaining_cash');
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
        Schema::dropIfExists('petty_cashes');
    }
};
