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
        Schema::create('holiday_images', function (Blueprint $table) {
            $table->unsignedInteger('id')->autoIncrement()->primary();
            $table->string('name',150);
            $table->unsignedInteger('holiday_id');
            $table->tinyInteger('sort')->index();
            $table->string('origin')->nullable();
            $table->foreign('holiday_id')->references('id')->on('holidays')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('holiday_images');
    }
};
