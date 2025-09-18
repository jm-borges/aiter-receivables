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
        Schema::create('opt_ins', function (Blueprint $table) {
            $table->uuid('id')->primary();

            // Relacionamentos
            $table->uuid('contract_id')->nullable()->index();
            $table->uuid('client_id')->nullable()->index();
            $table->uuid('acquirer_id')->nullable()->index();
            $table->uuid('payment_arrangement_id')->nullable()->index();

            // ARRANJO DE PAGAMENTO
            $table->unsignedInteger('codInstitdrArrajPgto')->nullable();

            // ADQUIRENTE
            $table->string('cnpjCreddrSub')->nullable();

            // CLIENTE
            $table->string('cnpjOuCnpjBaseOuCpfUsuFinalRecbdrOuTitlar')->nullable();

            // Outros campos
            $table->string('status')->nullable();
            $table->string('identdCtrlReqSolicte')->nullable();
            $table->string('cnpj_financiadora')->nullable();
            $table->string('identdCtrlOptIn')->nullable();
            $table->string('indrDomcl')->nullable();
            $table->dateTime('dtOptIn')->nullable();
            $table->date('dtIniOptIn')->nullable();
            $table->date('dtFimOptIn')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('opt_ins');
    }
};
