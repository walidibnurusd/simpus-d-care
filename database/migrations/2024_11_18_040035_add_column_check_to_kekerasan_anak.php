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
        Schema::table('kekerasan_anak', function (Blueprint $table) {
            $table->longText('tanda_kekerasan_check')->after('penelantaran_fisik');
            $table->longText('derajat_luka_bakar')->nullable()->after('penelantaran_fisik');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kekerasan_anak', function (Blueprint $table) {
            $table->dropColumn('tanda_kekerasan_check');
            $table->dropColumn('derajat_luka_bakar');
        });
    }
};
