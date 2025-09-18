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

            // Relacionamentos
            $table->uuid('opt_in_id')->nullable()->index();
            $table->uuid('client_id')->nullable()->index();
            $table->uuid('acquirer_id')->nullable()->index();
            $table->uuid('payment_arrangement_id')->nullable()->index();
            $table->uuid('contract_id')->nullable()->index();

            // Dados do recebível
            $table->string('tpObj')->nullable();
            $table->string('cnpjER')->nullable();
            $table->string('cnpjCreddrSub')->nullable();
            $table->string('codInstitdrArrajPgto')->nullable();
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
