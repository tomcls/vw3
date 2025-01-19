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
        Schema::create('holiday_types', function (Blueprint $table) {
            $table->unsignedInteger('id')->autoIncrement()->primary();
            $table->string('code',30)->index();
            $table->tinyInteger('order')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('holiday_types');
    }
};
