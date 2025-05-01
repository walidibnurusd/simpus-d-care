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
        $table->unsignedBigInteger('id_rujuk_poli')->nullable(); // buat nullable dulu
    });

    // Tambahkan foreign key setelah data dipastikan cocok
    Schema::table('actions', function (Blueprint $table) {
        $table->foreign('id_rujuk_poli')->references('id')->on('poli')->onDelete('cascade');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('actions', function (Blueprint $table) {
            $table->dropColumn(['id_rujuk_poli']);
        });
    }
};
