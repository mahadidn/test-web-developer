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
        Schema::create('cpmk', function (Blueprint $table) {
            $table->id();
            $table->string("kode_cpl");
            $table->string('kode_cpmk')->unique();
            $table->text('deskripsi');
            $table->timestamps();

            $table->foreign('kode_cpl')->references('kode_cpl')->on('cpl')->onDelete("CASCADE")->onUpdate("CASCADE");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cpmk');
    }
};
