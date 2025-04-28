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
        Schema::create('layak_hamil', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pasien');
            // $table->string('no_hp');
            // $table->string('nik')->unique();
            $table->enum('status', ['PUS', 'Catin']);
            $table->string('nama_suami')->nullable();
            // $table->string('alamat');
            $table->boolean('ingin_hamil');
            // $table->date('tanggal_lahir');
            $table->enum('umur', ['<20', '20-35', '36-40', '>40']);
            $table->enum('jumlah_anak', ['>3', '1-2', '0']);
            $table->enum('waktu_persalinan_terakhir', ['<2', '>2', '0']);
            $table->enum('lingkar_lengan_atas', ['<23.5', '>23.5', '0']);
            $table->json('penyakit')->nullable(); // Store multiple checkbox values as JSON
            $table->json('penyakit_suami')->nullable(); // JSON for husband's diseases
            $table->json('kesehatan_jiwa')->nullable(); // JSON for mental health questions
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
        Schema::dropIfExists('layak_hamil');
    }
};
