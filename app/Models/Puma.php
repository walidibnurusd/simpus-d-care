<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Puma extends Model
{
    use HasFactory;
    protected $table = 'puma';

    protected $fillable = ['nama', 'puskesmas', 'petugas', 'jenis_kelamin', 'usia', 'merokok', 'jumlah_rokok', 'lama_rokok', 'rokok_per_tahun', 'nafas_pendek', 'punya_dahak', 'batuk', 'periksa_paru', 'klaster', 'poli'];
}
