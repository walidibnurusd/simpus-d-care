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
        Schema::create('kanker_kolorektal', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pasien');
            $table->foreign('pasien')->references('id')->on('patients')->onDelete('cascade');
            // $table->string('nama');
            // $table->date('tanggal');
            // $table->integer('jenis_kelamin')->nullable();
            $table->integer('usia')->nullable();
            $table->integer('riwayat_kanker')->nullable();
            $table->integer('merokok')->nullable();
            $table->string('bercampur_darah')->nullable();
            $table->string('diare_kronis')->nullable();
            $table->string('bab_kambing')->nullable();
            $table->string('konstipasi_kronis')->nullable();
            $table->string('frekuensi_defekasi')->nullable();
            
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
        Schema::dropIfExists('kanker_kolorektal');
    }
};
