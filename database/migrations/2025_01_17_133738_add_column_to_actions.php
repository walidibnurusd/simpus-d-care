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
        Schema::table('actions', function (Blueprint $table) {
            $table->integer('layanan_kb')->nullable();
            $table->integer('jmlh_anak_laki')->nullable();
            $table->integer('jmlh_anak_perempuan')->nullable();
            $table->integer('status_kb')->nullable();
            $table->date('tgl_lahir_anak_bungsu')->nullable();
            $table->integer('kb_terakhir')->nullable();
            $table->date('tgl_kb_terakhir')->nullable();
            $table->integer('keadaan_umum')->nullable();
            $table->boolean('informed_concern')->nullable();
            $table->boolean('sakit_kuning')->nullable();
            $table->boolean('pendarahan_vagina')->nullable();
            $table->boolean('tumor')->nullable();
            $table->boolean('diabetes')->nullable();
            $table->boolean('pembekuan_darah')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('actions', function (Blueprint $table) {});
    }
};
