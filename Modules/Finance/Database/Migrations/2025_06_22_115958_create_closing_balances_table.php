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
        Schema::create('closing_balances', function (Blueprint $table) {
            $table->id();
 
            // Financial breakdown
            $table->decimal('amount', 12, 2)->comment('Total verified (cash + online)');
            $table->decimal('cash_amount', 12, 2)->default(0)->comment('Cash collected — needs physical deposit');
            $table->decimal('online_amount', 12, 2)->default(0)->comment('Online/card — auto-credited to bank');
 
            // Date is the business day — one record per day
            $table->date('date')->unique();
 
            // pending  → day closed, cash not yet deposited to bank
            // deposited → all cash has been deposited
            $table->string('status')->default('pending');
 
            $table->text('notes')->nullable();
 
            // Soft-delete support (optional but useful for auditing)
            $table->softDeletes();
 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('closing_balances');
    }
};
