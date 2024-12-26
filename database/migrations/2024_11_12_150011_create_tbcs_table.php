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
        Schema::create('tbc', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pasien');
            // $table->string('nama');
            $table->string('tempat_skrining');
            // $table->date('tanggal_lahir');
            // $table->string('alamat_ktp')->nullable();
            // $table->string('alamat_domisili')->nullable();
            // $table->string('nik')->nullable();
            // $table->string('pekerjaan')->nullable();
            // $table->string('jenis_kelamin')->nullable();
            // $table->string('no_hp')->nullable();
            $table->integer('tinggi_badan')->default(0);
            $table->integer('berat_badan')->default(0);
            $table->integer('status_gizi')->nullable();
            $table->integer('kontak_dengan_pasien')->nullable();
            $table->integer('kontak_tbc')->nullable();
            $table->integer('jenis_tbc')->nullable();
            $table->boolean('pernah_berobat_tbc')->default(0);
            $table->string('kapan')->nullable();
            $table->boolean('pernah_berobat_tbc_tdk_tuntas')->default(0);
            $table->boolean('kurang_gizi')->default(0);
            $table->boolean('merokok')->default(0);
            $table->boolean('perokok_pasif')->default(0);
            $table->integer('kencing_manis')->nullable();
            $table->integer('odhiv')->nullable();
            $table->boolean('lansia')->default(0);
            $table->boolean('ibu_hamil')->default(0);
            $table->boolean('tinggal_wilayah_kumuh')->default(0);
            $table->boolean('batuk')->default(0);
            $table->string('durasi')->nullable();
            $table->boolean('batuk_darah')->default(0);
            $table->boolean('bb_turun')->default(0);
            $table->boolean('demam')->default(0);
            $table->boolean('lesu')->default(0);
            $table->boolean('pembesaran_kelenjar')->default(0);
            $table->boolean('sudah_rontgen')->default(0);
            $table->string('hasil_rontgen')->nullable();
            $table->boolean('terduga_tbc')->default(0);
            $table->boolean('periksa_tbc_laten')->default(0);
            $table->integer('usia')->default(0);
            $table->integer('imt')->default(0);
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
        Schema::dropIfExists('tbcs');
    }
};
