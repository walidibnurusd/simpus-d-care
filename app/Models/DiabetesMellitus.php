<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiabetesMellitus extends Model
{
    use HasFactory;
     protected $table = 'diabetes_mellitus';

    protected $fillable = ['pasien','hasil','tinggi_badan','berat_badan','lingkar_perut','tekanan_darah_sistol','tekanan_darah_diastol', 'klaster', 'poli','kesimpulan'];
   
<<<<<<< HEAD
      public function pasien()
=======
      public function listPasien()
>>>>>>> 9df8fede466960d27744a11e4cb830e2a9437611
    {
        return $this->belongsTo(Patients::class, 'pasien', 'id');
    }
}
