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
        Schema::create('survey_kontak', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('malaria');
            $table->foreign('malaria')->references('id')->on('malaria')->onDelete('cascade');
            $table->string('nama')->nullable();
            $table->string('umur')->nullable();
            $table->boolean('jenis_kelamin')->default(0);
            $table->string('alamat')->nullable();
            $table->string('hub_kasus')->nullable();
            $table->date('tgl_pengambilan_darah')->nullable();
            $table->date('tgl_diagnosis')->nullable();
            $table->string('hasil_pemeriksaan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('survey_kontak');
    }
};
