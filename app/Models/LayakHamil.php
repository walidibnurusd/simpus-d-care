<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LayakHamil extends Model
{
    use HasFactory;
    protected $table = 'layak_hamil';

    protected $fillable = ['pasien',  'status', 'nama_suami',  'ingin_hamil',  'umur', 'jumlah_anak', 'waktu_persalinan_terakhir', 'lingkar_lengan_atas', 'penyakit', 'penyakit_suami', 'kesehatan_jiwa', 'klaster', 'poli','kesimpulan'];

    protected $casts = [
        'penyakit' => 'array',
        'penyakit_suami' => 'array',
        'kesehatan_jiwa' => 'array',
    ];
    public function listPasien()
    {
        return $this->belongsTo(Patients::class, 'pasien', 'id');
    }
}
