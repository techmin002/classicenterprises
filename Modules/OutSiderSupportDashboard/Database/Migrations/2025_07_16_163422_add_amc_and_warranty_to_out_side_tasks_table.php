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
        Schema::table('out_side_tasks', function (Blueprint $table) {
            $table->enum('amc', ['in', 'out'])->nullable()->after('priority');
            $table->enum('warranty', ['in', 'out'])->nullable()->after('amc');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('out_side_tasks', function (Blueprint $table) {
            $table->dropColumn(['amc', 'warranty']);
        });
    }
};
