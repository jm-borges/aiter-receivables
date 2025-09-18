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
        Schema::create('business_partners', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->string('name')->nullable();
            $table->string('fantasy_name')->nullable();
            $table->text('description')->nullable();
            $table->string('type')->nullable();

            $table->string('document_number')->nullable()->index();
            $table->string('state_subscription')->nullable();
            $table->string('city_subscription')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();

            $table->string('postal_code')->nullable();
            $table->string('address')->nullable();
            $table->string('address_number')->nullable();
            $table->string('address_complement')->nullable();
            $table->string('address_neighborhood')->nullable();
            $table->string('address_city')->nullable();
            $table->string('address_city_code')->nullable();
            $table->string('address_state')->nullable();
            $table->string('address_state_code')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('business_partners');
    }
};
