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
        Schema::table('customers', function (Blueprint $table) {
            $table->date('warranty_in')->nullable()->after('status');
            $table->date('warranty_out')->nullable()->after('warranty_in');
            $table->boolean('warranty_lifetime')->default(0)->after('warranty_out');
        });
    }

    public function down()
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn(['warranty_in', 'warranty_out', 'warranty_lifetime']);
        });
    }
};
