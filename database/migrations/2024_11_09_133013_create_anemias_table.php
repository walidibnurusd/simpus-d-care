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
        Schema::create('anemia', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pasien');
            $table->foreign('pasien')->references('id')->on('patients')->onDelete('cascade');
            $table->boolean('keluhan_5l')->default(false);
            $table->boolean('mudah_mengantuk')->default(false);
            $table->boolean('sulit_konsentrasi')->default(false);
            $table->boolean('sering_pusing')->default(false);
            $table->boolean('sakit_kepala')->default(false);
            $table->boolean('riwayat_talasemia')->default(false);
            $table->longText('gaya_hidup')->nullable();
            $table->boolean('makan_lemak')->default(false);
            $table->boolean('kongjungtiva_pucat')->default(false);
            $table->boolean('pucat')->default(false);
            $table->longText('kadar_hemoglobin')->nullable();
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
        Schema::dropIfExists('anemias');
    }
};
