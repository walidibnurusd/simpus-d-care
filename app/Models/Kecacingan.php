<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kecacingan extends Model
{
    use HasFactory;
    protected $table = 'kecacingan';

    protected $fillable = ['pasien', 'sakit_perut', 'diare', 'bab_darah', 'bab_cacing', 'nafsu_makan_turun', 'gatal', 'badan_lemah', 'kulit_pucat', 'klaster', 'poli','kesimpulan'];

     public function listPasien()
    {
        return $this->belongsTo(Patients::class, 'pasien', 'id');
    }
}
