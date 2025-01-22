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
        Schema::create('holiday_titles', function (Blueprint $table) {
            $table->unsignedInteger('id')->autoIncrement()->primary();
            $table->unsignedInteger('holiday_id');
            $table->string('name')->index();
            $table->string('slug')->index();
            $table->string('privilege')->nullable();
            $table->string('lang',2)->index();
            $table->unique(['holiday_id', 'lang']);
            $table->foreign('holiday_id')->references('id')->on('holidays')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('holiday_titles');
    }
};
