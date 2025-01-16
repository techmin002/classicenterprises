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
        Schema::create('leads', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('mobile');
            $table->string('landline')->nullable();
            $table->string('email')->nullable();
            $table->longText('address');
            $table->longText('message')->nullable();
            $table->string('branch_id')->nullable();
            $table->string('created_by')->nullable();
            $table->string('lead_type')->default('cold');
            $table->dateTime('followups')->nullable();
            $table->string('status')->default('non_convert');
            $table->softDeletes();
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
        Schema::dropIfExists('leads');
    }
};
