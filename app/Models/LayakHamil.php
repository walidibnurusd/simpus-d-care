<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LayakHamil extends Model
{
    use HasFactory;
    protected $table = 'layak_hamil';

    protected $fillable = ['nama', 'no_hp', 'nik', 'status', 'nama_suami', 'alamat', 'ingin_hamil', 'tanggal_lahir', 'umur', 'jumlah_anak', 'waktu_persalinan_terakhir', 'lingkar_lengan_atas', 'penyakit', 'penyakit_suami', 'kesehatan_jiwa', 'klaster', 'poli'];

    protected $casts = [
        'penyakit' => 'array',
        'penyakit_suami' => 'array',
        'kesehatan_jiwa' => 'array',
    ];
}
