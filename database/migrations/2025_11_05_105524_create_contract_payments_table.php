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
        Schema::create('contract_payments', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('contract_id')->nullable()->index();
            $table->string('status')->nullable();
            $table->double('amount')->nullable();
            $table->date('payment_date')->nullable();
            $table->date('due_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contract_payments');
    }
};
