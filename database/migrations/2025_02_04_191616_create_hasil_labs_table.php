<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('hasil_labs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_action');
            $table->foreign('id_action')->references('id')->on('actions')->onDelete('cascade');
            $table->text('jenis_pemeriksaan')->nullable();
            $table->string('gds')->nullable();
            $table->string('gdp')->nullable();
            $table->string('gdp_2_jam_pp')->nullable();
            $table->string('cholesterol')->nullable();
            $table->string('asam_urat')->nullable();
            $table->string('leukosit')->nullable();
            $table->string('eritrosit')->nullable();
            $table->string('trombosit')->nullable();
            $table->string('hemoglobin')->nullable();
            $table->string('sifilis')->nullable();
            $table->string('hiv')->nullable();
            $table->string('golongan_darah')->nullable();
            $table->string('widal')->nullable();
            $table->string('malaria')->nullable();
            $table->string('albumin')->nullable();
            $table->string('reduksi')->nullable();
            $table->string('urinalisa')->nullable();
            $table->string('tes_kehamilan')->nullable();
            $table->string('telur_cacing')->nullable();
            $table->string('bta')->nullable();
            $table->string('igm_dbd')->nullable();
            $table->string('igm_typhoid')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hasil_labs');
    }
};
