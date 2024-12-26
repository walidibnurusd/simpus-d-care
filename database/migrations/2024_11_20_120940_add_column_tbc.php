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
        Schema::table('tbc', function (Blueprint $table) {
            $table->integer('usia')->after('tanggal_lahir')->default(0);
            $table->integer('imt')->after('berat_badan')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbc', function (Blueprint $table) {
            //
        });
    }
};
