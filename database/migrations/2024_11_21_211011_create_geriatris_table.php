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
        Schema::create('geriatri', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pasien');
            $table->foreign('pasien')->references('id')->on('patients')->onDelete('cascade');
            $table->integer('tempat_waktu')->default(0);
            $table->integer('ulang_kata')->default(0);
            $table->integer('tes_berdiri')->default(0);
            $table->integer('pakaian')->default(0);
            $table->integer('nafsu_makan')->default(0);
            $table->integer('ukuran_lingkar')->default(0);
            $table->integer('tes_melihat')->default(0);
            $table->integer('hitung_jari')->default(0);
            $table->integer('tes_bisik')->default(0);
            $table->integer('perasaan_sedih')->default(0);
            $table->integer('kesenangan')->default(0);
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
        Schema::dropIfExists('geriatri');
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
        Schema::create('geriatri', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pasien');
            $table->foreign('pasien')->references('id')->on('patients')->onDelete('cascade');
            $table->integer('tempat_waktu')->default(0);
            $table->integer('ulang_kata')->default(0);
            $table->integer('tes_berdiri')->default(0);
            $table->integer('pakaian')->default(0);
            $table->integer('nafsu_makan')->default(0);
            $table->integer('ukuran_lingkar')->default(0);
            $table->integer('tes_melihat')->default(0);
            $table->integer('hitung_jari')->default(0);
            $table->integer('tes_bisik')->default(0);
            $table->integer('perasaan_sedih')->default(0);
            $table->integer('kesenangan')->default(0);
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
        Schema::dropIfExists('geriatri');
    }
};
>>>>>>> 9df8fede466960d27744a11e4cb830e2a9437611
