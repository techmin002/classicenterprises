<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTicketPaymentColumnsToPaymentVerificationsTable extends Migration
{
    public function up()
    {
        Schema::table('payment_verifications', function (Blueprint $table) {
            // ✅ Add ticket_id if not exists
            if (!Schema::hasColumn('payment_verifications', 'ticket_id')) {
                $table->unsignedBigInteger('ticket_id')->nullable()->after('branch_id');
                $table->foreign('ticket_id')
                      ->references('id')
                      ->on('customer_tickets')
                      ->onDelete('set null');
            }

            // ✅ Add customer_payment_id if not exists
            if (!Schema::hasColumn('payment_verifications', 'customer_payment_id')) {
                $table->unsignedBigInteger('customer_payment_id')->nullable()->after('ticket_id');
                $table->foreign('customer_payment_id')
                      ->references('id')
                      ->on('customer_payments')
                      ->onDelete('set null');
            }

            // ✅ Add customer_ticket_payment_id if not exists
            if (!Schema::hasColumn('payment_verifications', 'customer_ticket_payment_id')) {
                $table->unsignedBigInteger('customer_ticket_payment_id')->nullable()->after('customer_payment_id');
                $table->foreign('customer_ticket_payment_id')
                      ->references('id')
                      ->on('customer_ticket_payments')
                      ->onDelete('set null');
            }
        });
    }

    public function down()
    {
        Schema::table('payment_verifications', function (Blueprint $table) {
            $table->dropForeign(['ticket_id']);
            $table->dropForeign(['customer_payment_id']);
            $table->dropForeign(['customer_ticket_payment_id']);
            $table->dropColumn(['ticket_id', 'customer_payment_id', 'customer_ticket_payment_id']);
        });
    }
}