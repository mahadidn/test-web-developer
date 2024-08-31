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
            $table->id();
            $table->string('user_id')->unique();
            $table->string('password');
            $table->string('token', 100)->nullable()->unique();
            $table->string('name');
            $table->binary('photo');
            $table->json("rights");
            $table->timestamps();
            // $table->string('email')->unique();
            // $table->timestamp('email_verified_at')->nullable();

            // $table->rememberToken();
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
