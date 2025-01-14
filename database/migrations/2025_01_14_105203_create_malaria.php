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
        Schema::create('malaria', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pasien');
            $table->foreign('pasien')->references('id')->on('patients')->onDelete('cascade');
            $table->string('alamat')->nullable();
            $table->longText('gejala')->nullable();
            $table->longText('jenis_wilayah')->nullable();
            $table->date('tanggal_gejala')->nullable();
            $table->boolean('hasil_darah')->default(0);
            $table->longText('jenis_parasit')->nullable();
            $table->boolean('riwayat_malaria')->default(0);
            $table->string('waktu')->nullable();
            $table->string('jenis_parasit_malaria')->nullable();
            $table->string('jenis_obat_malaria')->nullable();
            $table->date('tanggal_diagnosis')->nullable();
            $table->string('diagnosis')->nullable();
            $table->string('fasyankes')->nullable();
            $table->string('perawatan')->nullable();
            $table->string('no_rm')->nullable();
            $table->string('metode_diagnosis')->nullable();
            $table->string('jenis_parasit_malaria_sebelumnya')->nullable();
            $table->date('riwayat_tanggal_gejala')->nullable();
            $table->boolean('riwayat_kasus_malaria')->default(0);
            $table->string('kasus_waktu')->nullable();
            $table->string('kasus_jenis_parasit')->nullable();
            $table->string('kasus_jenis_obat')->nullable();
            $table->date('tanggal_pengobatan')->nullable();
            $table->string('jmlh_obat_dhp')->nullable();
            $table->string('jmlh_obat_primaquin')->nullable();
            $table->string('jmlh_obat_artesunat')->nullable();
            $table->string('jmlh_obat_artemeter')->nullable();
            $table->string('jmlh_obat_kina')->nullable();
            $table->string('jmlh_obat_klindamisin')->nullable();
            $table->boolean('obat_habis')->default(0);
            $table->string('riwayat_desa_1')->nullable();
            $table->string('riwayat_desa_2')->nullable();
            $table->string('riwayat_desa_3')->nullable();
            $table->string('riwayat_kecamatan_1')->nullable();
            $table->string('riwayat_kecamatan_2')->nullable();
            $table->string('riwayat_kecamatan_3')->nullable();
            $table->string('riwayat_kabupaten_1')->nullable();
            $table->string('riwayat_kabupaten_2')->nullable();
            $table->string('riwayat_kabupaten_3')->nullable();
            $table->string('riwayat_provinsi_1')->nullable();
            $table->string('riwayat_provinsi_2')->nullable();
            $table->string('riwayat_provinsi_3')->nullable();
            $table->string('riwayat_negara_1')->nullable();
            $table->string('riwayat_negara_2')->nullable();
            $table->string('riwayat_negara_3')->nullable();
            $table->string('riwayat_jenis_wilayah_1')->nullable();
            $table->string('riwayat_jenis_wilayah_2')->nullable();
            $table->string('riwayat_jenis_wilayah_3')->nullable();
            $table->string('riwayat_kepentingan_1')->nullable();
            $table->string('riwayat_kepentingan_2')->nullable();
            $table->string('riwayat_kepentingan_3')->nullable();
            $table->boolean('obat_profilaksis')->default(0);
            $table->boolean('transfusi_darah')->default(0);
            $table->boolean('kontak_kasus')->default(0);
            $table->string('import_desa')->nullable();
            $table->string('import_kabupaten')->nullable();
            $table->string('import_provinsi')->nullable();
            $table->string('import_negara')->nullable();
            $table->string('kegiatan1')->nullable();
            $table->string('tempat1')->nullable();
            $table->string('kegiatan2')->nullable();
            $table->string('tempat2')->nullable();
            $table->string('kegiatan3')->nullable();
            $table->string('tempat3')->nullable();
            $table->string('kegiatan4')->nullable();
            $table->string('tempat4')->nullable();
            $table->string('kegiatan5')->nullable();
            $table->string('tempat5')->nullable();
            $table->string('kegiatan6')->nullable();
            $table->string('tempat6')->nullable();
            $table->string('kegiatan_sosial')->nullable();
            $table->string('kabupaten')->nullable();
            $table->string('kecamatan')->nullable();
            $table->string('desa')->nullable();
            $table->string('dusun')->nullable();
            $table->date('tanggal_survey')->nullable();
            $table->string('kolektor')->nullable();
            $table->longText('kesimpulan')->nullable();
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
        Schema::dropIfExists('malaria');
    }
};
