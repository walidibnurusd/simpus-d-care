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
        Schema::create('kecacingan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pasien');
            $table->foreign('pasien')->references('id')->on('patients')->onDelete('cascade');
            $table->boolean('sakit_perut')->default(false);
            $table->boolean('diare')->default(false);
            $table->boolean('bab_darah')->default(false);
            $table->boolean('bab_cacing')->default(false);
            $table->boolean('nafsu_makan_turun')->default(false);
            $table->boolean('gatal')->default(false);
            $table->boolean('badan_lemah')->default(false);
            $table->boolean('kulit_pucat')->default(false);
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
        Schema::dropIfExists('kecacingans');
    }
};
