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
        Schema::table('payment_verifications', function (Blueprint $table) {
            $table->string('customer_type')->default('classic')->after('receipt');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payment_verifications', function (Blueprint $table) {
            $table->dropColumn('customer_type');
        });
    }
};
