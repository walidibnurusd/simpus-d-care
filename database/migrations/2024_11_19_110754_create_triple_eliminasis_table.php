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
        Schema::create('triple_eliminasi', function (Blueprint $table) {
            $table->id();
            $table->string('nama')->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->integer('pekerjaan')->default(0);
            $table->integer('status_kawin')->default(0);
            $table->integer('gravida')->default(0);
            $table->integer('partus')->default(0);
            $table->integer('abortus')->default(0);
            $table->integer('umur_kehamilan')->default(0);
            $table->string('taksiran_kehamilan')->nullable();
            $table->string('nama_puskesmas')->nullable();
            $table->string('kode_specimen')->nullable();
            $table->string('no_hp')->nullable();
            $table->string('umur_ibu')->nullable();
            $table->string('alamat')->nullable();
            $table->integer('pendidikan')->default(0);
            $table->boolean('gejala_hepatitis')->default(0);
            $table->string('gejala_urine_gelap')->nullable();
            $table->string('gejala_kuning')->nullable();
            $table->string('gejala_lainnya')->nullable();
            $table->boolean('test_hepatitis')->default(0);
            $table->string('lokasi_tes')->nullable();
            $table->date('tanggal_tes')->nullable();
            $table->string('anti_hbs')->nullable();
            $table->string('anti_hbc')->nullable();
            $table->string('sgpt')->nullable();
            $table->string('anti_hbe')->nullable();
            $table->string('hbeag')->nullable();
            $table->string('hbv_dna')->nullable();
            $table->boolean('transfusi_darah')->default(0);
            $table->string('kapan_transfusi')->nullable();
            $table->boolean('hemodialisa')->default(0);
            $table->string('kapan_hemodialisa')->nullable();
            $table->integer('jmlh_pasangan_seks')->default(0);
            $table->boolean('narkoba')->default(0);
            $table->string('kapan_narkoba')->nullable();
            $table->boolean('vaksin')->default(0);
            $table->string('kapan_vaksin')->nullable();
            $table->integer('jmlh_vaksin')->default(0);
            $table->boolean('tinggal_serumah')->default(0);
            $table->string('kapan_tinggal_serumah')->nullable();
            $table->integer('hubungan_hepatitis')->default(0);
            $table->string('hubungan_detail')->nullable();
            $table->boolean('test_hiv')->default(0);
            $table->integer('hasil_hiv')->default(0);
            $table->boolean('cd4_check')->default(0);
            $table->string('dimana_cd4')->nullable();
            $table->integer('hasil_cd4')->default(0);
            $table->boolean('arv_check')->default(0);
            $table->date('kapan_arv')->nullable();
            $table->boolean('gejala_pms')->default(0);
            $table->date('kapan_pms')->nullable();
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
        Schema::dropIfExists('triple_eliminasi');
    }
};
