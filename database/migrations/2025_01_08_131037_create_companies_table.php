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
        Schema::create('companies', function (Blueprint $table) {
            $table->unsignedInteger('id')->autoIncrement()->primary();
            $table->string('name', 150);
            $table->string('vat', 25)->nullable();
            $table->string('phone', 40)->nullable();
            $table->string('email', 150);
            $table->string('country', 3)->nullable();
            $table->string('city', 50)->nullable();
            $table->string('zip', 10)->nullable();
            $table->string('street', 200)->nullable();
            $table->string('street_number', 7)->nullable();
            $table->string('street_box', 7)->nullable();
            $table->boolean('active')->default(false);
            $table->boolean('is_agency')->default(false);
            $table->string('partner', 50)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
