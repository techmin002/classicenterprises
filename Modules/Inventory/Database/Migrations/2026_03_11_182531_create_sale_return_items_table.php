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
        Schema::create('sale_return_items', function (Blueprint $table) {

            $table->id();
            $table->unsignedBigInteger('sale_return_id');

            $table->unsignedBigInteger('accessory_id')->nullable();
            $table->unsignedBigInteger('machinery_id')->nullable();

            $table->string('name');
            $table->integer('quantity');
            $table->decimal('price',12,2);
            $table->decimal('total',12,2);

            $table->timestamps();

            $table->foreign('sale_return_id')
                ->references('id')
                ->on('sale_returns')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sale_return_items');
    }
};
