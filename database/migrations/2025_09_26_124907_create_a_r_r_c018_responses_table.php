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
        Schema::create('arrc018_responses', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('payment_arrangement_id')->nullable();
            $table->string('source_file_name')->nullable();
            $table->string('participant_document')->nullable();
            $table->string('managed_participant_id')->nullable();
            $table->string('trade_repository_document')->nullable();
            $table->string('payment_scheme_code')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('a_r_r_c018_responses');
    }
};
