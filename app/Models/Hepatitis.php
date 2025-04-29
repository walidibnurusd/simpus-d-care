<<<<<<< HEAD
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hepatitis extends Model
{
    use HasFactory;
    protected $table = 'hepatitis';

    protected $fillable = ['pasien', 'sudah_periksa_hepatitis', 'keluhan', 'demam', 'dapat_transfusi_darah', 'sering_seks', 'narkoba', 'vaksin_hepatitis_b', 'keluarga_hepatitis', 'menderita_penyakit_menular', 'hasil_hiv', 'klaster', 'poli','kesimpulan'];
    protected $casts = [
        'keluhan' => 'array',
    ];
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

class Hepatitis extends Model
{
    use HasFactory;
    protected $table = 'hepatitis';

    protected $fillable = ['pasien', 'sudah_periksa_hepatitis', 'keluhan', 'demam', 'dapat_transfusi_darah', 'sering_seks', 'narkoba', 'vaksin_hepatitis_b', 'keluarga_hepatitis', 'menderita_penyakit_menular', 'hasil_hiv', 'klaster', 'poli','kesimpulan'];
    protected $casts = [
        'keluhan' => 'array',
    ];
       public function listPasien()
    {
        return $this->belongsTo(Patients::class, 'pasien', 'id');
    }

}
>>>>>>> 9df8fede466960d27744a11e4cb830e2a9437611
