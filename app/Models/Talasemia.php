<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Talasemia extends Model
{
    use HasFactory;
    protected $table = 'talasemia';

    protected $fillable = ['pasien', 'terima_darah', 'saudara_talasemia', 'keluarga_transfusi', 'keluarga_transfusi', 'pubertas_telat', 'anemia', 'ikterus', 'faices_cooley', 'perut_buncit', 'gizi_buruk', 'tubuh_pendek', 'hipergimentasi_kulit', 'klaster','poli'];

        public function listPasien()
    {
        return $this->belongsTo(Patients::class, 'pasien', 'id');
    }
}
