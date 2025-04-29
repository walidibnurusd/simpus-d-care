<<<<<<< HEAD
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KekerasanAnak extends Model
{
    use HasFactory;
    protected $table = 'kekerasan_anak';

    protected $fillable = ['pasien', 'diperoleh_dari', 'hubungan_pasien', 'kekerasan', 'tempat', 'dampak_pasien', 'dampak_pada_anak', 'penelantaran_fisik', 'tanda_kekerasan_check','tanda_kekerasan', 'kekerasan_seksual','derajat_luka_bakar' ,'dampak_kekerasan', 'klaster', 'poli','kesimpulan','tempat_lain'];
    protected $casts = [
        'kekerasan' => 'array',
        'tempat' => 'array',
        'dampak_pasien' => 'array',
        'dampak_pada_anak' => 'array',
        'penelantaran_fisik' => 'array',
        'tanda_kekerasan_check' => 'array',
        'tanda_kekerasan' => 'array',
        'kekerasan_seksual' => 'array',
        'dampak_kekerasan' => 'array',
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

class KekerasanAnak extends Model
{
    use HasFactory;
    protected $table = 'kekerasan_anak';

    protected $fillable = ['pasien', 'diperoleh_dari', 'hubungan_pasien', 'kekerasan', 'tempat', 'dampak_pasien', 'dampak_pada_anak', 'penelantaran_fisik', 'tanda_kekerasan_check','tanda_kekerasan', 'kekerasan_seksual','derajat_luka_bakar' ,'dampak_kekerasan', 'klaster', 'poli','kesimpulan','tempat_lain'];
    protected $casts = [
        'kekerasan' => 'array',
        'tempat' => 'array',
        'dampak_pasien' => 'array',
        'dampak_pada_anak' => 'array',
        'penelantaran_fisik' => 'array',
        'tanda_kekerasan_check' => 'array',
        'tanda_kekerasan' => 'array',
        'kekerasan_seksual' => 'array',
        'dampak_kekerasan' => 'array',
    ];
     public function listPasien()
    {
        return $this->belongsTo(Patients::class, 'pasien', 'id');
    }
}
>>>>>>> 9df8fede466960d27744a11e4cb830e2a9437611
