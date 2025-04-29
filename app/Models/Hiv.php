<<<<<<< HEAD
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hiv extends Model
{
    use HasFactory;
    protected $table = 'hiv';

    protected $fillable = ['pasien', 'tes_hiv', 'tanggal_tes_terakhir', 'penurunan_berat', 'jumlah_berat_badan_turun', 'penyakit_kulit', 'gejala_ispa', 'gejala_sariawan', 'riwayat_sesak', 'riwayat_haptitis', 'riwayat_seks_bebas', 'riwayat_narkoba', 'riwayat_penyakit_menular', 'klaster', 'poli','kesimpulan'];
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

class Hiv extends Model
{
    use HasFactory;
    protected $table = 'hiv';

    protected $fillable = ['pasien', 'tes_hiv', 'tanggal_tes_terakhir', 'penurunan_berat', 'jumlah_berat_badan_turun', 'penyakit_kulit', 'gejala_ispa', 'gejala_sariawan', 'riwayat_sesak', 'riwayat_haptitis', 'riwayat_seks_bebas', 'riwayat_narkoba', 'riwayat_penyakit_menular', 'klaster', 'poli','kesimpulan'];
    public function listPasien()
    {
        return $this->belongsTo(Patients::class, 'pasien', 'id');
    }
}
>>>>>>> 9df8fede466960d27744a11e4cb830e2a9437611
