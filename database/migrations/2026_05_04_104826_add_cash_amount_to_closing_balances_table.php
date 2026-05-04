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
        Schema::table('closing_balances', function (Blueprint $table) {
             $table->decimal('cash_amount', 15, 2)
                  ->default(0)
                  ->after('amount'); // adjust position if needed
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('closing_balances', function (Blueprint $table) {
            //
        });
    }
};
