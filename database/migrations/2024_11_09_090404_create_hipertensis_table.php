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
        Schema::create('hipertensi', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pasien');
            $table->boolean('ortu_hipertensi')->default(false);
            $table->boolean('saudara_hipertensi')->default(false);
            $table->boolean('tubuh_gemuk')->default(false);
            $table->boolean('usia_50')->default(false);
            $table->boolean('merokok')->default(false);
            $table->boolean('makan_asin')->default(false);
            $table->boolean('makan_santan')->default(false);
            $table->boolean('makan_lemak')->default(false);
            $table->boolean('sakit_kepala')->default(false);
            $table->boolean('sakit_tenguk')->default(false);
            $table->boolean('tertekan')->default(false);
            $table->boolean('sulit_tidur')->default(false);
            $table->boolean('rutin_olahraga')->default(false);
            $table->boolean('makan_sayur')->default(false);
            $table->boolean('makan_buah')->default(false);
            $table->integer('jmlh_rokok')->default(0);
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
