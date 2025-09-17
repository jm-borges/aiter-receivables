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
        Schema::create('operations', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('status')->nullable();
            $table->string('cnpjER')->nullable();
            $table->string('identdNegcRecbvl')->nullable();
            $table->string('identdOp')->nullable();
            $table->string('indrTpNegc')->nullable();
            $table->date('dtVencOp')->nullable();
            $table->decimal('vlrTotLimOuSldDevdr')->nullable();
            $table->decimal('vlrGar')->nullable();
            $table->string('indrGestER')->nullable();
            $table->string('indrRegrDivs')->nullable();
            $table->string('indrAlcancContrtoCreddrSub')->nullable();
            $table->string('indrActeIncondlOp')->nullable();
            $table->string('identdCIPOpOrRenegcDiv')->nullable();
            $table->string('indrActeUniddRecbvlReserv')->nullable();
            $table->string('indrPeriodRecalc')->nullable();
            $table->string('diaExeccRecalc')->nullable();
            $table->timestamp('dtHrIncl')->nullable();
            $table->string('indrSitOp')->nullable();
            $table->string('indrAutcCess')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('operations');
    }
};
