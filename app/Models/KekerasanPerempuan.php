<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KekerasanPerempuan extends Model
{
    use HasFactory;
    protected $table = 'kekerasan_perempuan';

    protected $fillable = ['no_responden', 'umur', 'tempat_wawancara', 'hubungan_dengan_pasangan', 'mengatasi_pertengkaran_mulur', 'akibat_pertengkaran_mulut', 'pasangan_memukul', 'ketakutan', 'dibatasi', 'klaster', 'poli'];
   
}
