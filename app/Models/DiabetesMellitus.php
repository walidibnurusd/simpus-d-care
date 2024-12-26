<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiabetesMellitus extends Model
{
    use HasFactory;
     protected $table = 'diabetes_mellitus';

    protected $fillable = ['nama', 'tanggal_lahir', 'tempat_lahir','alamat','penyakit_dulu','penyakit_sekarang','penyakit_keluarga','tinggi_badan','berat_badan','lingkar_perut','tekanan_darah_sistol','tekanan_darah_diastol', 'klaster', 'poli'];
   
}
