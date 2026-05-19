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
         Schema::create('deposite_amounts', function (Blueprint $table) {
            $table->id();
 
            // Link back to the closing day this deposit clears (nullable for legacy rows)
            $table->foreignId('closing_balance_id')
                  ->nullable()
                  ->constrained('closing_balances')
                  ->nullOnDelete();
 
            $table->decimal('amount', 12, 2);
            $table->string('bank_name');
 
            // Receipt image stored under public/upload/images/deposite-amount/
            $table->string('image')->nullable();
 
            // The calendar date the deposit was physically made
            $table->date('date');
 
            // Always 'deposited' for now; kept for future workflow states
            $table->string('status')->default('deposited');
 
            $table->text('notes')->nullable();
 
            $table->softDeletes();
 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deposite_amounts');
    }
};
