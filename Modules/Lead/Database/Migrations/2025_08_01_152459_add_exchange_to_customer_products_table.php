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
        Schema::table('customer_products', function (Blueprint $table) {
            $table->string('exchange')->default('no')->after('product_total'); // or boolean if preferred
            $table->decimal('total_exchange', 10, 2)->nullable()->after('exchange');
        });
    }

    public function down(): void
    {
        Schema::table('customer_products', function (Blueprint $table) {
            $table->dropColumn(['exchange', 'total_exchange']);
        });
    }
};
