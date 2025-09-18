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
        Schema::create('opt_outs', function (Blueprint $table) {
            $table->uuid('id')->primary();

            // Relacionamento com OptIn
            $table->uuid('opt_in_id')->nullable()->index();

            // Status e identificadores
            $table->string('status')->nullable();
            $table->string('identd_ctrl_opt_in')->nullable();
            $table->string('identdCtrlReqSolicte')->nullable();
            $table->string('identdCtrlOptOut')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('opt_outs');
    }
};
