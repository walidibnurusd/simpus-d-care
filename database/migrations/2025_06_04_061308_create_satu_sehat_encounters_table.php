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
            // database/migrations/xxxx_xx_xx_create_satu_sehat_encounters_table.php
        Schema::create('satu_sehat_encounters', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('action_id')->unique(); // Unique untuk mencegah duplikat
            $table->string('encounter_id')->nullable();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('satu_sehat_encounters');
    }
};
