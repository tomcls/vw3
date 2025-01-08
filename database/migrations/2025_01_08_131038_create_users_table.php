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
        Schema::create('users', function (Blueprint $table) {
            $table->unsignedInteger('id')->autoIncrement()->primary();
            $table->string('firstname', 150);
            $table->string('lastname', 150);
            $table->string('email', 150);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('phone', 40)->nullable();
            $table->string('lang', 2)->default('fr');
            $table->string('country', 3)->nullable();
            $table->string('city', 50)->nullable();
            $table->string('zip', 10)->nullable();
            $table->string('street', 200)->nullable();
            $table->string('street_number', 7)->nullable();
            $table->string('street_box', 7)->nullable();
            $table->string('avatar', 200)->nullable();
            $table->string('more_info')->nullable();
            $table->string('password', 150);
            $table->string('remember_token', 100)->nullable();
            $table->string('code', 25)->nullable();
            $table->boolean('active')->default(false);
            $table->boolean('optin_newsletter')->default(false);
            $table->unsignedInteger('company_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
