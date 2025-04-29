<<<<<<< HEAD
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tbc extends Model
{
    use HasFactory;
        protected $table = 'tbc';

    protected $fillable = ['pasien', 'tempat_skrining', 'tinggi_badan','berat_badan','status_gizi','kontak_dengan_pasien','kontak_tbc','jenis_tbc','pernah_berobat_tbc','kapan','pernah_berobat_tbc_tdk_tuntas','kurang_gizi','merokok','perokok_pasif','kencing_manis','odhiv','lansia','ibu_hamil','tinggal_wilayah_kumuh','batuk','durasi','batuk_darah','bb_turun','demam','lesu','pembesaran_kelenjar','sudah_rontgen','hasil_rontgen','terduga_tbc','periksa_tbc_laten', 'klaster','poli','imt','usia','kesimpulan'];
    public function listPasien()
    {
        return $this->belongsTo(Patients::class, 'pasien', 'id');
    }
}
=======
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tbc extends Model
{
    use HasFactory;
        protected $table = 'tbc';

    protected $fillable = ['pasien', 'tempat_skrining', 'tinggi_badan','berat_badan','status_gizi','kontak_dengan_pasien','kontak_tbc','jenis_tbc','pernah_berobat_tbc','kapan','pernah_berobat_tbc_tdk_tuntas','kurang_gizi','merokok','perokok_pasif','kencing_manis','odhiv','lansia','ibu_hamil','tinggal_wilayah_kumuh','batuk','durasi','batuk_darah','bb_turun','demam','lesu','pembesaran_kelenjar','sudah_rontgen','hasil_rontgen','terduga_tbc','periksa_tbc_laten', 'klaster','poli','imt','usia','kesimpulan'];
    public function listPasien()
    {
        return $this->belongsTo(Patients::class, 'pasien', 'id');
    }
}
>>>>>>> 9df8fede466960d27744a11e4cb830e2a9437611
