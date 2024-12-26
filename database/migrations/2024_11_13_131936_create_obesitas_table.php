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
            $table->string('nama');
            $table->date('tanggal_lahir');
            $table->string('tempat_lahir')->nullable();
            $table->string('alamat')->nullable();
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
