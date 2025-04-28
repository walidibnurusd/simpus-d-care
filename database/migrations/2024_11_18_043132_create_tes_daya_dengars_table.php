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
        Schema::create('tes_daya_dengar', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pasien');
            // $table->string('nama');
            // $table->date('tanggal');
            // $table->string('jenis_kelamin')->nullable();
            $table->string('usia');
            $table->longText('ekspresif')->nullable();
            $table->longText('reseptif')->nullable();
            $table->longText('visual')->nullable();
            $table->integer('klaster');
            $table->string('poli');
            $table->timestamps();
            $table->foreign('pasien')->references('id')->on('patients')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tes_daya_dengar');
    }
};
