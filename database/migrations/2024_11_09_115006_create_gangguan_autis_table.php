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
        Schema::create('gangguan_autis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pasien');
            $table->foreign('pasien')->references('id')->on('patients')->onDelete('cascade');
            $table->boolean('lihat_objek')->default(false);
            $table->boolean('tuli')->default(false);
            $table->boolean('main_pura_pura')->default(false);
            $table->boolean('suka_manjat')->default(false);
            $table->boolean('gerakan_jari')->default(false);
            $table->boolean('tunjuk_minta')->default(false);
            $table->boolean('tunjuk_menarik')->default(false);
            $table->boolean('tertarik_anak_lain')->default(false);
            $table->boolean('membawa_benda')->default(false);
            $table->boolean('respon_nama_dipanggil')->default(false);
            $table->boolean('respon_senyum')->default(false);
            $table->boolean('pernah_marah')->default(false);
            $table->boolean('bisa_jalan')->default(false);
            $table->boolean('menatap_mata')->default(false);
            $table->boolean('meniru')->default(false);
            $table->boolean('memutar_kepala')->default(false);
            $table->boolean('melihat')->default(false);
            $table->boolean('mengerti')->default(false);
            $table->boolean('menatap_wajah')->default(false);
            $table->boolean('suka_bergerak')->default(false);
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
        Schema::dropIfExists('gangguan_autis');
    }
};
