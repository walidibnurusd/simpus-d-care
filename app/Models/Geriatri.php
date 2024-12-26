<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Geriatri extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'geriatri';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'pasien',
        'tempat_waktu',
        'ulang_kata',
        'tes_berdiri',
        'pakaian',
        'nafsu_makan',
        'ukuran_lingkar',
        'tes_melihat',
        'hitung_jari',
        'tes_bisik',
        'perasaan_sedih',
        'kesenangan',
        'klaster',
        'poli',
    ];
         public function listPasien()
    {
        return $this->belongsTo(Patients::class, 'pasien', 'id');
    }
}
