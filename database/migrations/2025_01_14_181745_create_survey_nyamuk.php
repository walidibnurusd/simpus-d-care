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
        Schema::create('survey_nyamuk', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('malaria');
            $table->foreign('malaria')->references('id')->on('malaria')->onDelete('cascade');
            $table->string('habitat')->nullable();
            $table->string('ph')->nullable();
            $table->string('sal')->nullable();
            $table->string('suhu')->nullable();
            $table->string('kond')->nullable();
            $table->string('kept')->nullable();
            $table->string('dasar')->nullable();
            $table->string('air')->nullable();
            $table->string('sktr')->nullable();
            $table->string('teduh')->nullable();
            $table->string('predator')->nullable();
            $table->string('larva_an')->nullable();
            $table->string('larva_cx')->nullable();
            $table->string('jarak_kamp')->nullable();
            $table->string('klp_habitat')->nullable();
            $table->string('gps')->nullable();
            $table->string('catatan')->nullable();
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
