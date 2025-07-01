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
        Schema::create('stock_issue_machineries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('stock_issue_id');
            $table->unsignedBigInteger('machinery_id');
            $table->integer('quantity')->default(1);
            $table->timestamps();

            $table->foreign('stock_issue_id')->references('id')->on('stock_issues')->onDelete('cascade');
            $table->foreign('machinery_id')->references('id')->on('machineries')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_issue_machineries');
    }
};
