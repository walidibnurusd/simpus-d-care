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
        Schema::create('obesitas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pasien');
            $table->foreign('pasien')->references('id')->on('patients')->onDelete('cascade');
            $table->decimal('tinggi_badan')->default(0);
            $table->decimal('berat_badan')->default(0);
            $table->decimal('lingkar_peru')->default(0);
            $table->integer('klaster');
            $table->string('poli');
            $table->timestamps();
        });
    }

    /**P
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('obesitas');
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
        Schema::create('obesitas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pasien');
            $table->foreign('pasien')->references('id')->on('patients')->onDelete('cascade');
            $table->decimal('tinggi_badan')->default(0);
            $table->decimal('berat_badan')->default(0);
            $table->decimal('lingkar_peru')->default(0);
            $table->integer('klaster');
            $table->string('poli');
            $table->timestamps();
        });
    }

    /**P
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('obesitas');
    }
};
>>>>>>> 9df8fede466960d27744a11e4cb830e2a9437611
