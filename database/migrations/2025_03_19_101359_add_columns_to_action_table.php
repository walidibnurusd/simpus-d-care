<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('actions', function (Blueprint $table) {
            $table->text('alergi')->nullable(); // Alergi
            $table->string('gangguan_ginjal')->nullable(); // Gangguan Ginjal/Hati
            $table->boolean('menyusui')->default(0); // Menyusui (0 = Tidak, 1 = Ya)
        });
    }

    public function down()
    {
        Schema::table('actions', function (Blueprint $table) {
            $table->dropColumn([
                 'alergi', 'gangguan_ginjal', 'menyusui'
            ]);
        });
    }

};
