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
        Schema::create('actions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_patient');
            $table->date('tanggal');
            $table->string('doctor');
            $table->string('kunjungan');
            $table->string('kartu');
            $table->string('nomor');
            $table->string('faskes');
            $table->string('sistol');
            $table->string('diastol');
            $table->decimal('beratBadan');
            $table->decimal('tinggiBadan');
            $table->decimal('lingkarPinggang');
            $table->string('gula');
            $table->string('merokok');
            $table->string('fisik');
            $table->string('gula_lebih');
            $table->string('garam');
            $table->string('lemak');
            $table->string('buah_sayur');
            $table->string('alkohol');
            $table->string('hidup');
            $table->string('hasil_iva');
            $table->string('tindak_iva');
            $table->string('hasil_sadanis');
            $table->string('tindak_sadanis');
            $table->string('konseling');
            $table->string('car');
            $table->string('rujuk_ubm');
            $table->string('kondisi');
            $table->string('edukasi');
            $table->string('riwayat_penyakit_keluarga');
            $table->string('riwayat_penyakit_tidak_menular');
            $table->string('keluhan');
            $table->string('diagnosa');
            $table->string('tindakan');
            $table->unsignedBigInteger('rujuk_rs');
            $table->string('keterangan');
            $table->timestamps();
            $table->foreign('id_patient')->references('id')->on('patients')->onDelete('cascade');
            // $table->foreign('id_doctor')->references('id')->on('doctors')->onDelete('cascade');
            // $table->foreign('diagnosa')->references('id')->on('diagnosis')->onDelete('cascade');
            $table->foreign('rujuk_rs')->references('id')->on('hospitals')->onDelete('cascade');
            // $table->foreign('riwayat_penyakit_keluarga')->references('id')->on('diseases')->onDelete('cascade');
            // $table->foreign('riwayat_penyakit_tidak_menular')->references('id')->on('diseases')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('actions');
    }
};
