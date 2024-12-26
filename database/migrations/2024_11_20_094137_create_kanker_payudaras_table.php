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
        Schema::create('kanker_payudara', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pasien');
            $table->foreign('pasien')->references('id')->on('patients')->onDelete('cascade');
            $table->string('nomor_klien')->default(0);
            // $table->string('nama')->nullable();
            $table->integer('umur')->default(0);
            $table->string('suku_bangsa')->nullable();
            $table->string('agama')->nullable();
            $table->integer('berat_badan')->nullable();
            $table->integer('tinggi_badan')->nullable();
            // $table->string('alamat')->nullable();
            $table->integer('perkawinan_pasangan')->default(0);
            $table->integer('klien')->default(0);
            $table->string('pekerjaan_klien')->nullable();
            $table->string('pekerjaan_suami')->nullable();
            $table->string('pendidikan_terakhir')->nullable();
            $table->integer('jmlh_anak_kandung')->default(0);
            $table->string('rt_rw')->nullable();
            $table->string('kelurahan_desa')->nullable();
            $table->boolean('menstruasi')->default(0);
            $table->boolean('usia_seks')->default(0);
            $table->boolean('keputihan')->default(0);
            $table->boolean('merokok')->default(0);
            $table->boolean('terpapar_asap_rokok')->default(0);
            $table->boolean('konsumsi_buah_sayur')->default(0);
            $table->boolean('konsumsi_makanan_lemak')->default(0);
            $table->boolean('konsumsi_makanan_pengawet')->default(0);
            $table->boolean('kurang_aktivitas')->default(0);
            $table->boolean('pap_smear')->default(0);
            $table->boolean('berganti_pasangan')->default(0);
            $table->boolean('riwayat_kanker')->default(0);
            $table->string('jenis_kanker')->nullable();
            $table->boolean('kehamilan_pertama')->default(0);
            $table->boolean('menyusui')->default(0);
            $table->boolean('melahirkan')->default(0);
            $table->boolean('melahirkan_4_kali')->default(0);
            $table->boolean('menikah_lbh_1')->default(0);
            $table->boolean('kb_hormonal_pil')->default(0);
            $table->boolean('kb_hormonal_suntik')->default(0);
            $table->boolean('tumor_jinak')->default(0);
            $table->boolean('menopause')->default(0);
            $table->boolean('obesitas')->default(0);
            $table->longText('kulit')->nullable();
            $table->longText('areola')->nullable();
            $table->boolean('benjolan')->default(0);
            $table->integer('ukuran_benjolan')->default(0);
            $table->longText('normal')->nullable();
            $table->longText('kelainan_jinak')->nullable();
            $table->longText('kelainan_ganas')->nullable();
            $table->boolean('vulva')->default(0);
            $table->string('vulva_details')->nullable();
            $table->boolean('vagina')->default(0);
            $table->string('vagina_details')->nullable();
            $table->boolean('serviks')->default(0);
            $table->string('serviks_details')->nullable();
            $table->boolean('uterus')->default(0);
            $table->string('uterus_details')->nullable();
            $table->boolean('adnexa')->default(0);
            $table->string('adnexa_details')->nullable();
            $table->boolean('rectovaginal')->default(0);
            $table->string('rectovaginal_details')->nullable();
            $table->longText('iva_negatif')->nullable();
            $table->longText('iva_positif')->nullable();
            $table->date('tanggal_kunjungan')->nullable();
            $table->string('lainnya')->nullable();
            $table->longText('ims')->nullable();
            $table->string('detail_diobati')->nullable();
            $table->string('dirujuk')->nullable();
            $table->longText('rujukan')->nullable();
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
        Schema::dropIfExists('kanker_payudara');
    }
};
