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
        Schema::create('gangguan_jiwa_dewasa', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pasien');
            $table->foreign('pasien')->references('id')->on('patients')->onDelete('cascade');
            $table->boolean('sakit_kepala')->default(0);
            $table->boolean('hilang_nafsu_makan')->default(0);
            $table->boolean('tidur_nyenyak')->default(0);
            $table->boolean('takut')->default(0);
            $table->boolean('cemas')->default(0);
            $table->boolean('tangan_gemetar')->default(0);
            $table->boolean('gangguan_pencernaan')->default(0);
            $table->boolean('sulit_berpikir_jernih')->default(0);
            $table->boolean('tdk_bahagia')->default(0);
            $table->boolean('sering_menangis')->default(0);
            $table->boolean('sulit_aktivitas')->default(0);
            $table->boolean('sulit_ambil_keputusan')->default(0);
            $table->boolean('tugas_terbengkalai')->default(0);
            $table->boolean('tdk_berperan')->default(0);
            $table->boolean('hilang_minat')->default(0);
            $table->boolean('tdk_berharga')->default(0);
            $table->boolean('pikiran_mati')->default(0);
            $table->boolean('lelah_selalu')->default(0);
            $table->boolean('sakit_perut')->default(0);
            $table->boolean('mudah_lelah')->default(0);
            $table->longText('kesimpulan');
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
        Schema::dropIfExists('puma');
    }
};
