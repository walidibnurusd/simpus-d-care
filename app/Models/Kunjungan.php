<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kunjungan extends Model
{
    use HasFactory;
    protected $table = 'kunjungan';

    protected $fillable = ['pasien','poli','hamil','tanggal'];
  public function patient()
    {
        return $this->belongsTo(Patients::class, 'pasien', 'id');
    }
  
}
