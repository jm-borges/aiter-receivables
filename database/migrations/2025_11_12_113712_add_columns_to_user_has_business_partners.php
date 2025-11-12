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
        Schema::table('user_has_business_partners', function (Blueprint $table) {
            $table->date('opt_in_start_date')->nullable();
            $table->date('opt_in_end_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_has_business_partners', function (Blueprint $table) {
            //
        });
    }
};
