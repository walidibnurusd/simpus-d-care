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
        Schema::create('merokok', function (Blueprint $table) {
            $table->id();
            $table->string('no_kuesioner')->nullable();
            $table->string('sekolah')->nullable();
            $table->string('provinsi')->nullable();
            $table->string('puskesmas')->nullable();
            $table->string('petugas')->nullable();
            $table->string('name_responden')->nullable();
            $table->string('nik')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->integer('umur')->default(0);
            $table->string('jenis_kelamin')->nullable();
            $table->integer('merokok')->default(0);
            $table->longText('jenis_rokok')->nullable();
            $table->string('jenis_rokok_lainnya')->nullable();
            $table->integer('usia_merokok')->default(0);
            $table->longText('alasan_merokok')->nullable();
            $table->string('alasan_merokok_lainnya')->nullable();
            $table->integer('batang_per_hari')->default(0);
            $table->integer('batang_per_minggu')->default(0);
            $table->integer('lama_merokok_minggu')->default(0);
            $table->integer('lama_merokok_bulan')->default(0);
            $table->integer('lama_merokok_tahun')->default(0);
            $table->longText('dapat_rokok')->nullable();
            $table->string('dapat_rokok_lainnya')->nullable();
            $table->boolean('berhenti_merokok')->default(0);
            $table->longText('alasan_berhenti_merokok')->nullable();
            $table->string('alasan_berhenti_merokok_lainnya')->nullable();
            $table->boolean('tau_bahaya_rokok')->default(0);
            $table->boolean('melihat_orang_merokok')->default(0);
            $table->longText('orang_merokok')->nullable();
            $table->string('orang_merokok_lainnya')->nullable();
            $table->boolean('anggota_keluarga_merokok')->default(0);
            $table->boolean('teman_merokok')->default(0);
            $table->boolean('periksa_co2')->default(0);
            $table->integer('kadar_co2')->default(0);
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
        Schema::dropIfExists('merokok');
    }
};
