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
        Schema::create('gangguan_jiwa_remaja', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->date('tanggal_lahir');
            $table->string('alamat')->nullable();
            $table->string('jenis_kelamin')->nullable();
            $table->integer('peduli_perasaan')->default(0);
            $table->integer('gelisah')->default(0);
            $table->integer('sakit')->default(0);
            $table->integer('berbagi')->default(0);
            $table->integer('marah')->default(0);
            $table->integer('suka_sendiri')->default(0);
            $table->integer('penurut')->default(0);
            $table->integer('cemas')->default(0);
            $table->integer('siap_menolong')->default(0);
            $table->integer('badan_bergerak')->default(0);
            $table->integer('punya_teman')->default(0);
            $table->integer('suka_bertengkar')->default(0);
            $table->integer('tdk_bahagia')->default(0);
            $table->integer('disukai')->default(0);
            $table->integer('mudah_teralih')->default(0);
            $table->integer('gugup')->default(0);
            $table->integer('baik_pada_anak')->default(0);
            $table->integer('bohong')->default(0);
            $table->integer('diancam')->default(0);
            $table->integer('suka_bantu')->default(0);
            $table->integer('kritis')->default(0);
            $table->integer('mencuri')->default(0);
            $table->integer('mudah_berteman')->default(0);
            $table->integer('takut')->default(0);
            $table->integer('rajin')->default(0);
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
        Schema::dropIfExists('gangguan_jiwa_remaja');
    }
};
