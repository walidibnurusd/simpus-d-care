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
        Schema::create('kekerasan_anak', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pasien');
            $table->foreign('pasien')->references('id')->on('patients')->onDelete('cascade');
            $table->string('diperoleh_dari');
            $table->string('hubungan_pasien');
            $table->longText('kekerasan')->nullable();
            $table->longText('tempat')->nullable();
            $table->longText('dampak_pasien')->nullable();
            $table->longText('dampak_pada_anak')->nullable();
            $table->longText('penelantaran_fisik')->nullable();
            $table->longText('tanda_kekerasan')->nullable();
            $table->longText('kekerasan_seksual')->nullable();
            $table->longText('dampak_kekerasan')->nullable();
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
        Schema::dropIfExists('kekerasan_anaks');
    }
};
