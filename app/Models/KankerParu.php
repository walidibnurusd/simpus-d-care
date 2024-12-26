<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KankerParu extends Model
{
    use HasFactory;

    protected $table = 'kanker_paru';

    protected $fillable = [
        'nama', 
        'tanggal', 
        'jenis_kelamin', 
        'usia', 
        'kanker', 
        'keluarga_kanker', 
        'merokok', 
        'riwayat_tempat_kerja', 
        'tempat_tinggal', 
        'lingkungan_rumah', 
        'paru_kronik', 
        'klaster', 
        'poli'
    ];

}
