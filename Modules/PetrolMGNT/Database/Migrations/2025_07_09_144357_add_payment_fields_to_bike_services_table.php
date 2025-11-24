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
        Schema::table('bike_services', function (Blueprint $table) {
            $table->string('payment_type')->nullable()->after('km');
            $table->string('cheque_number')->nullable()->after('mode');
            $table->string('service_center')->nullable()->after('cheque_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bike_services', function (Blueprint $table) {
            $table->dropColumn(['payment_type', 'cheque_number', 'petrol_pump']);
        });
    }
};
