<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventoriesTable extends Migration
{
    public function up()
    {
        Schema::create('inventories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('machinery_id')->nullable()->constrained('machineries')->nullOnDelete();
            $table->foreignId('accessory_id')->nullable()->constrained('accessories')->nullOnDelete();
            $table->foreignId('branch_id')->constrained()->cascadeOnDelete();
            $table->integer('quantity')->default(0);
            $table->integer('opening_quantity')->default(0);
            $table->foreignId('updated_by')->constrained('users')->cascadeOnDelete();
            $table->boolean('status')->default(true);
            $table->timestamps();

            $table->unique(['machinery_id', 'accessory_id', 'branch_id'], 'inventory_unique');
        });
    }

    public function down()
    {
        Schema::dropIfExists('inventories');
    }
}
