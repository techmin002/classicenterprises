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
    Schema::table('payment_verifications', function (Blueprint $table) {
        $table->unsignedBigInteger('customer_ticket_payment_id')->nullable()->after('customer_id');
        $table->foreign('customer_ticket_payment_id')
              ->references('id')
              ->on('customer_ticket_payments')
              ->onDelete('set null');
    });
}

public function down()
{
    Schema::table('payment_verifications', function (Blueprint $table) {
        $table->dropForeign(['customer_ticket_payment_id']);
        $table->dropColumn('customer_ticket_payment_id');
    });
}
};
