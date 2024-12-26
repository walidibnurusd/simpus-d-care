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
        Schema::create('kekerasan_perempuan', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->integer('no_responden');
            $table->integer('umur');
            $table->string('tempat_wawancara');
            $table->integer('hubungan_dengan_pasangan');
            $table->integer('mengatasi_pertengkaran_mulur');
            $table->integer('akibat_pertengkaran_mulut')->nullable();
            $table->integer('pasangan_memukul')->nullable();
            $table->integer('ketakutan')->nullable();
            $table->integer('dibatasi')->nullable();
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
        Schema::dropIfExists('kekerasan_perempuans');
    }
};
