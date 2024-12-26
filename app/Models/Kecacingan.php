<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kecacingan extends Model
{
    use HasFactory;
    protected $table = 'kecacingan';

    protected $fillable = ['nama', 'tanggal_lahir', 'jenis_kelamin', 'alamat', 'sakit_perut', 'diara', 'bab_darah', 'bab_cacing', 'nafsu_makan_turun', 'gatal', 'badan_lemah', 'kulit_pucat', 'klaster', 'poli'];
}
