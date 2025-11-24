<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDevicePurchaseMachineriesTable extends Migration
{
    public function up()
    {
        Schema::create('device_purchase_machineries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('device_purchase_id')->constrained()->cascadeOnDelete();
            $table->foreignId('machinery_id')->constrained('machineries')->cascadeOnDelete();
            $table->foreignId('branch_id')->constrained()->cascadeOnDelete();
            $table->integer('quantity');
            $table->decimal('unit_price', 15, 2);
            $table->decimal('total', 15, 2);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('device_purchase_machineries');
    }
}
