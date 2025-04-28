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
        Schema::create('action_obat', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_action');
            $table->foreign('id_action')->references('id')->on('actions')->onDelete('cascade');
            $table->unsignedBigInteger('id_obat');
            $table->foreign('id_obat')->references('id')->on('obat')->onDelete('cascade');
            $table->string('dose')->nullable();
            $table->integer('amount')->nullable();
            $table->integer('shape')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('action_obat');
    }
};
