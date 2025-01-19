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
        Schema::create('holidays', function (Blueprint $table) {
            $table->unsignedInteger('id')->autoIncrement()->primary();
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('holiday_type_id');
            $table->dateTime('startdate')->index();
            $table->dateTime('enddate')->index();
            $table->decimal('longitude',18,15)->nullable()->index();
            $table->decimal('latitude',18,15)->nullable()->index();
            $table->string('phone',30)->nullable();
            $table->string('email',150)->nullable();
            $table->tinyInteger('number_people',false)->unsigned()->nullable();
            $table->tinyInteger('stars')->nullable()->index();
            $table->boolean('active')->default(false)->index();
            $table->string('external_id',50)->index();
            $table->boolean('read_trip')->index();
            $table->boolean('flash_deal')->index();
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('holiday_type_id')->references('id')->on('holiday_types')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('holidays');
    }
};
