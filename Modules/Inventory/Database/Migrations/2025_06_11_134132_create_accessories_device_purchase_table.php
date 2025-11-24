<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('accessories_device_purchase', function (Blueprint $table) {
            $table->id();
            $table->foreignId('device_purchase_id')->constrained('device_purchases')->onDelete('cascade');
            $table->foreignId('accessories_id')->constrained('accessories')->onDelete('cascade');
            $table->integer('quantity')->default(1);
            $table->decimal('price', 10, 2)->default(0);
            $table->decimal('total', 10, 2)->default(0);
            $table->foreignId('branch_id')->nullable()->constrained('branches')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('accessories_device_purchase');
    }
};


