<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('hepatitis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pasien');
            $table->foreign('pasien')->references('id')->on('patients')->onDelete('cascade');
            $table->boolean('sudah_periksa_hepatitis')->default(false);
            $table->longText('keluhan')->nullable();
            $table->boolean('demam')->default(false);
            $table->boolean('dapat_transfusi_darah')->default(false);
            $table->boolean('sering_seks')->default(false);
            $table->boolean('narkoba')->default(false);
            $table->longText('vaksin_hepatitis_b')->nullable();
            $table->boolean('keluarga_hepatitis')->default(false);
            $table->boolean('menderita_penyakit_menular')->default(false);
            $table->integer('hasil_hiv');
            $table->integer('klaster');
            $table->string('poli');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hepatitis');
    }
};
