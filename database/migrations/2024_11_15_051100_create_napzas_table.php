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
        Schema::create('napza', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pasien');
            $table->string('nama_dokter');
            $table->string('klinik')->nullable();
            $table->longText('pertanyaan1')->nullable();
            $table->longText('pertanyaan2')->nullable();
            $table->longText('pertanyaan3')->nullable();
            $table->longText('pertanyaan4')->nullable();
            $table->longText('pertanyaan5')->nullable();
            $table->longText('pertanyaan6')->nullable();
            $table->longText('pertanyaan7')->nullable();
            $table->longText('pertanyaan8')->nullable();
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
        Schema::dropIfExists('napza');
    }
};
