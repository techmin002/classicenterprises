<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('stock_transfer_machineries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('stock_transfer_id');
            $table->unsignedBigInteger('machinery_id');
            $table->integer('quantity');
            $table->string('serial_numbers')->nullable();
            $table->enum('condition', ['new', 'used', 'refurbished', 'damaged']);
            $table->timestamps();

            $table->foreign('stock_transfer_id')->references('id')->on('stock_transfers')->onDelete('cascade');
            $table->foreign('machinery_id')->references('id')->on('machineries');
        });
    }

    public function down()
    {
        Schema::dropIfExists('stock_transfer_machineries');
    }
};