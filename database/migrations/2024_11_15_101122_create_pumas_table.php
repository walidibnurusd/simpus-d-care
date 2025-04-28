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
        Schema::create('puma', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pasien');
            // $table->string('nama');
            $table->string('puskesmas');
            $table->string('petugas')->nullable();
            // $table->string('jenis_kelamin')->nullable();
            $table->integer('usia')->default(0);
            $table->boolean('merokok')->default(0);
            $table->integer('jumlah_rokok')->default(0);
            $table->integer('lama_rokok')->default(0);
            $table->integer('rokok_per_tahun')->default(0);
            $table->boolean('nafas_pendek')->default(0);
            $table->boolean('punya_dahak')->default(0);
            $table->boolean('batuk')->default(0);
            $table->boolean('periksa_paru')->default(0);
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
        Schema::dropIfExists('puma');
    }
};
