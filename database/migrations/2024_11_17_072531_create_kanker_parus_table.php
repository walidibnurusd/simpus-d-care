<<<<<<< HEAD
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
        Schema::create('kanker_paru', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pasien');
            $table->foreign('pasien')->references('id')->on('patients')->onDelete('cascade');
            $table->integer('kanker')->nullable();
            $table->integer('keluarga_kanker')->nullable();
            $table->integer('merokok')->nullable();
            $table->integer('riwayat_tempat_kerja')->nullable();
            $table->integer('tempat_tinggal')->nullable();
            $table->integer('lingkungan_rumah')->nullable();
            $table->integer('paru_kronik')->default(0);
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
        Schema::dropIfExists('kanker_paru');
    }
};
=======
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
        Schema::create('kanker_paru', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pasien');
            $table->foreign('pasien')->references('id')->on('patients')->onDelete('cascade');
            $table->integer('kanker')->nullable();
            $table->integer('keluarga_kanker')->nullable();
            $table->integer('merokok')->nullable();
            $table->integer('riwayat_tempat_kerja')->nullable();
            $table->integer('tempat_tinggal')->nullable();
            $table->integer('lingkungan_rumah')->nullable();
            $table->integer('paru_kronik')->default(0);
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
        Schema::dropIfExists('kanker_paru');
    }
};
>>>>>>> 9df8fede466960d27744a11e4cb830e2a9437611
