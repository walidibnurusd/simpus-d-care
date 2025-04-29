<<<<<<< HEAD
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
        Schema::table('napza', function (Blueprint $table) {
            $table->string('nama_zat_lain')->after('pertanyaan1')->nullable();
            $table->string('zatlain_name_P2')->after('pertanyaan2')->nullable();
            // $table->string('nama_zat_lain')->after('pertanyaan8')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('napza', function (Blueprint $table) {
            $table->dropColumn('nama_zat_lain');
            $table->dropColumn('zatlain_name_P2');
        });
    }
};
=======
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
        Schema::table('napza', function (Blueprint $table) {
            $table->string('nama_zat_lain')->after('pertanyaan1')->nullable();
            $table->string('zatlain_name_P2')->after('pertanyaan2')->nullable();
            // $table->string('nama_zat_lain')->after('pertanyaan8')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('napza', function (Blueprint $table) {
            $table->dropColumn('nama_zat_lain');
            $table->dropColumn('zatlain_name_P2');
        });
    }
};
>>>>>>> 9df8fede466960d27744a11e4cb830e2a9437611
