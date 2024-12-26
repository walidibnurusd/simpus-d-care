<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anemia extends Model
{
    use HasFactory;
    protected $table = 'anemia';

    protected $fillable = ['nama', 'tanggal_lahir', 'jenis_kelamin', 'alamat', 'keluhan_5l', 'mudah_mengantuk', 'sulit_konsentrasi', 'sering_pusing', 'sakit_kepala', 'riwayat_talasemia', 'gaya_hidup', 'riwayat_talasemia', 'gaya_hidup', 'makan_lemak', 'kongjungtiva_pucat', 'pucat', 'kadar_hemoglobin', 'klaster', 'poli'];
    protected $casts = [
        'gaya_hidup' => 'array',
        'kadar_hemoglobin' => 'array',
    ];
}
