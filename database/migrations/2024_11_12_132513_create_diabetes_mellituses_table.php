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
        Schema::create('diabetes_mellitus', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pasien');
            $table->foreign('pasien')->references('id')->on('patients')->onDelete('cascade');
            $table->longText('penyakit_dulu')->nullable();
            $table->longText('penyakit_sekarang')->nullable();
            $table->longText('penyakit_keluarga')->nullable();
            $table->integer('tinggi_badan')->default(0);
            $table->integer('berat_badan')->default(0);
            $table->integer('lingkar_perut')->default(0);
            $table->integer('tekanan_darah_sistol')->default(0);
            $table->integer('tekanan_darah_diastol')->default(0);
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
        Schema::dropIfExists('diabetes_mellituses');
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
        Schema::create('diabetes_mellitus', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pasien');
            $table->foreign('pasien')->references('id')->on('patients')->onDelete('cascade');
            $table->longText('penyakit_dulu')->nullable();
            $table->longText('penyakit_sekarang')->nullable();
            $table->longText('penyakit_keluarga')->nullable();
            $table->integer('tinggi_badan')->default(0);
            $table->integer('berat_badan')->default(0);
            $table->integer('lingkar_perut')->default(0);
            $table->integer('tekanan_darah_sistol')->default(0);
            $table->integer('tekanan_darah_diastol')->default(0);
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
        Schema::dropIfExists('diabetes_mellituses');
    }
};
>>>>>>> 9df8fede466960d27744a11e4cb830e2a9437611
