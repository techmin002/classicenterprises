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
        Schema::create('lead_responses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('lead_id');
            $table->dateTime('followups')->nullable();
            $table->string('branch_id')->nullable();
            $table->string('created_by')->nullable();
            $table->text('message')->nullable();
            $table->string('status')->default('on');
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
        Schema::dropIfExists('lead_responses');
    }
};
