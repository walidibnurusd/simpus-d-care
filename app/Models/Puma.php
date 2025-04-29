<<<<<<< HEAD
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Puma extends Model
{
    use HasFactory;
    protected $table = 'puma';

    protected $fillable = ['pasien', 'puskesmas', 'petugas', 'usia', 'merokok', 'jumlah_rokok', 'lama_rokok', 'rokok_per_tahun', 'nafas_pendek', 'punya_dahak', 'batuk', 'periksa_paru', 'klaster', 'poli','kesimpulan'];
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

class Puma extends Model
{
    use HasFactory;
    protected $table = 'puma';

    protected $fillable = ['pasien', 'puskesmas', 'petugas', 'usia', 'merokok', 'jumlah_rokok', 'lama_rokok', 'rokok_per_tahun', 'nafas_pendek', 'punya_dahak', 'batuk', 'periksa_paru', 'klaster', 'poli','kesimpulan'];
    public function listPasien()
    {
        return $this->belongsTo(Patients::class, 'pasien', 'id');
    }
}
>>>>>>> 9df8fede466960d27744a11e4cb830e2a9437611
