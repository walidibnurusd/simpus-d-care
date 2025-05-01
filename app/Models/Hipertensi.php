<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hipertensi extends Model
{
    use HasFactory;
    protected $table = 'hipertensi';

    protected $fillable = ['pasien','ortu_hipertensi','saudara_hipertensi','tubuh_gemuk','usia_50','merokok','makan_asin','makan_santan','makan_lemak','sakit_kepala','sakit_tenguk','tertekan','sulit_tidur','rutin_olahraga','makan_sayur','makan_buah','klaster','poli','jmlh_rokok','kesimpulan'];

    public function listPasien()
    {
        return $this->belongsTo(Patients::class, 'pasien', 'id');
    }
}
