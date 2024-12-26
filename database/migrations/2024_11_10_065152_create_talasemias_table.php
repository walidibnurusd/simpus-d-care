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
        Schema::create('talasemia', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pasien');
            $table->foreign('pasien')->references('id')->on('patients')->onDelete('cascade');
            $table->boolean('terima_darah')->default(false);
            $table->boolean('saudara_talasemia')->default(false);
            $table->boolean('keluarga_transfusi')->default(false);
            $table->boolean('pubertas_telat')->default(false);
            $table->boolean('anemia')->default(false);
            $table->boolean('ikterus')->default(false);
            $table->longText('faices_cooley')->nullable();
            $table->boolean('perut_buncit')->default(false);
            $table->boolean('gizi_buruk')->default(false);
            $table->boolean('tubuh_pendek')->default(false);
            $table->longText('hipergimentasi_kulit')->nullable();
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
        Schema::dropIfExists('talasemias');
    }
};
