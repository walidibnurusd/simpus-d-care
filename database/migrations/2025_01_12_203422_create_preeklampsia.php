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
        Schema::create('preeklampsia', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pasien');
            $table->foreign('pasien')->references('id')->on('patients')->onDelete('cascade');
            $table->boolean('multipara')->default(0);
            $table->boolean('teknologi_hamil')->default(0);
            $table->boolean('umur35')->default(0);
            $table->boolean('nulipara')->default(0);
            $table->boolean('multipara10')->default(0);
            $table->boolean('riwayat_preeklampsia')->default(0);
            $table->boolean('obesitas')->default(0);
            $table->boolean('multipara_sebelumnya')->default(0);
            $table->boolean('hamil_multipel')->default(0);
            $table->boolean('diabetes')->default(0);
            $table->boolean('hipertensi')->default(0);
            $table->boolean('ginjal')->default(0);
            $table->boolean('autoimun')->default(0);
            $table->boolean('phospholipid')->default(0);
            $table->boolean('arterial')->default(0);
            $table->boolean('proteinura')->default(0);
            $table->longText('kesimpulan');
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
        Schema::dropIfExists('puma');
    }
};
