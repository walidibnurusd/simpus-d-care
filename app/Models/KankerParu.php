<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KankerParu extends Model
{
    use HasFactory;

    protected $table = 'kanker_paru';

    protected $fillable = [
        'pasien', 
        'keluarga_kanker', 
        'merokok', 
        'riwayat_tempat_kerja', 
        'tempat_tinggal', 
        'lingkungan_rumah', 
        'paru_kronik', 
        'klaster', 
        'poli',
        'kesimpulan',
        'kanker',
        'usia'
    ];
       public function listPasien()
    {
        return $this->belongsTo(Patients::class, 'pasien', 'id');
    }

}
