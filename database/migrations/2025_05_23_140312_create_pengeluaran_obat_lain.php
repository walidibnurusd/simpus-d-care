<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pengeluaran_obat_lain', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_obat');
            $table->foreign('id_obat')->references('id')->on('obat')->onDelete('cascade');
            $table->integer('amount');
            $table->integer('unit');
            $table->date('date');
            $table->longText('remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengeluaran_obat_lain');
    }
};
