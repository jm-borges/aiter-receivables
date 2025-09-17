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
        Schema::create('receivables', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('tpObj')->nullable();
            $table->string('cnpjER')->nullable();
            $table->string('cnpjCreddrSub')->nullable();
            $table->unsignedInteger('codInstitdrArrajPgto')->nullable();
            $table->string('cnpjOuCnpjBaseOuCpfUsuFinalRecbdr')->nullable();
            $table->double('vlrLivreUsuFinalRecbdr')->nullable();
            $table->date('dtPrevtLiquid')->nullable();
            $table->double('vlrTot')->nullable();
            $table->string('indrDomcl')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('receivables');
    }
};
