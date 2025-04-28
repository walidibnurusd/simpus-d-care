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
        Schema::table('actions', function (Blueprint $table) {
            $table->integer('usia_kehamilan')->default(0);
            $table->string('jenis_anc')->nullable();
            $table->integer('lingkar_lengan_atas')->default(0);
            $table->integer('tinggi_fundus_uteri')->default(0);
            $table->string('presentasi_janin')->nullable();
            $table->integer('denyut_jantung')->default(0);
            $table->boolean('kaki_bengkak')->default(0);
            $table->boolean('imunisasi_tt')->default(0);
            $table->boolean('tablet_fe')->default(0);
            $table->string('gravida')->nullable();
            $table->string('partus')->nullable();
            $table->string('abortus')->nullable();
            $table->boolean('proteinuria')->default(0);
            $table->string('hiv')->nullable();
            $table->string('sifilis')->nullable();
            $table->string('hepatitis')->nullable();
            $table->boolean('periksa_usg')->default(0);
            $table->string('hasil_usg')->nullable();
            $table->string('treatment_anc')->nullable();
            $table->string('kesimpulan')->nullable();
            $table->date('tanggal_kembali')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('actions', function (Blueprint $table) {
            $table->integer('usia_kehamilan')->default(0);
            $table->string('jenis_anc')->nullable();
            $table->integer('lingkar_lengan_atas')->default(0);
            $table->integer('tinggi_fundus_uteri')->default(0);
            $table->string('presentasi_janin')->nullable();
            $table->integer('denyut_jantung')->default(0);
            $table->boolean('kaki_bengkak')->default(0);
            $table->boolean('imunisasi_tt')->default(0);
            $table->boolean('tablet_fe')->default(0);
            $table->string('gravida')->nullable();
            $table->string('partus')->nullable();
            $table->string('abortus')->nullable();
            $table->boolean('proteinuria')->default(0);
            $table->string('hiv')->nullable();
            $table->string('sifilis')->nullable();
            $table->string('hepatitis')->nullable();
            $table->boolean('periksa_usg')->default(0);
            $table->string('hasil_usg')->nullable();
            $table->string('treatment_anc')->nullable();
            $table->string('kesimpulan')->nullable();
            $table->date('tanggal_kembali')->nullable();
        });
    }
};
