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
            $table->decimal('nadi')->default(0)->after('keterangan');
            $table->decimal('nafas')->default(0)->after('nadi');
            $table->decimal('suhu')->default(0)->after('nafas');
            $table->string('mata_anemia')->nullable()->after('suhu');
            $table->string('pupil')->nullable()->after('mata_anemia');
            $table->string('ikterus')->nullable()->after('pupil');
            $table->string('udem_palpebral')->nullable()->after('ikterus');
            $table->string('nyeri_tekan')->nullable()->after('udem_palpebral');
            $table->string('peristaltik')->nullable()->after('nyeri_tekan');
            $table->string('ascites')->nullable()->after('peristaltik');
            $table->string('lokasi_abdomen')->nullable()->after('ascites');
            $table->string('thorax')->nullable()->after('lokasi_abdomen');
            $table->string('thorax_bj')->nullable()->after('thorax');
            $table->string('paru')->nullable()->after('thorax_bj');
            $table->string('suara_nafas')->nullable()->after('paru');
            $table->string('ronchi')->nullable()->after('suara_nafas');
            $table->string('wheezing')->nullable()->after('ronchi');
            $table->string('ekstremitas')->nullable()->after('wheezing');
            $table->string('edema')->nullable()->after('ekstremitas');
            $table->string('tonsil')->nullable()->after('edema');
            $table->string('fharing')->nullable()->after('tonsil');
            $table->string('kelenjar')->nullable()->after('fharing');
            $table->string('genetalia')->nullable()->after('kelenjar');
            $table->string('warna_kulit')->nullable()->after('genetalia');
            $table->string('turgor')->nullable()->after('warna_kulit');
            $table->string('neurologis')->nullable()->after('turgor');
            $table->string('hasil_lab')->nullable()->after('neurologis');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('actions', function (Blueprint $table) {
            //
        });
    }
};
