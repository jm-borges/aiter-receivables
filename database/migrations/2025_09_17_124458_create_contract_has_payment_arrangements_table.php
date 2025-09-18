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
        Schema::create('contract_has_payment_arrangements', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->uuid('contract_id')->nullable()->index();
            $table->uuid('payment_arrangement_id')->nullable()->index();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contract_has_payment_arrangements');
    }
};
