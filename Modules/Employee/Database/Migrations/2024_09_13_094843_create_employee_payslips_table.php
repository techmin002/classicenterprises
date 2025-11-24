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
        Schema::create('employee_payslips', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('employee_id');
            $table->string('month')->nullable();
            $table->decimal('salary',10,2)->default(0.00);
            $table->decimal('net_salary',10,2)->default(0.00);
            $table->string('advance_pay')->nullable();
            $table->string('sales_insentive')->nullable();
            $table->string('service_insentive')->nullable();
            $table->string('allowance')->nullable();
            $table->decimal('fund',10,2)->default(0.00);
            $table->string('created_by')->nullable();
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
        Schema::dropIfExists('employee_payslips');
    }
};
