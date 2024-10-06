<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_sale_insentives', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->integer('employee_id');
            $table->decimal('insentive_amount',10,2)->default(0.00);
            $table->decimal('sale_amount',10,2)->default(0.00);
            $table->text('description')->nullable();
            $table->string('type')->default('fixed');
            $table->date('date')->nullable();
            $table->date('paid_date')->nullable();
            $table->string('status')->default('on');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employee_sale_insentives');
    }
};
