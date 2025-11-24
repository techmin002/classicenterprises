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
        Schema::create('employee_advance_pays', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('employee_id');
            $table->string('title');
            $table->decimal('amount',10,2)->default(0.00);
            $table->longText('reason')->nullable();
            $table->date('date')->nullable();
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
        Schema::dropIfExists('employee_advance_pays');
    }
};
