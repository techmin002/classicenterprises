<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('amc_assign_accessories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('amc_assign_id');
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('amc_id');
            $table->unsignedBigInteger('accessory_id');
            $table->integer('quantity')->default(1);
            $table->timestamps();

            $table->foreign('amc_assign_id')->references('id')->on('amc_assigns')->onDelete('cascade');
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->foreign('amc_id')->references('id')->on('amcs')->onDelete('cascade');
            $table->foreign('accessory_id')->references('id')->on('accessories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('amc_assign_accessories');
    }
};
