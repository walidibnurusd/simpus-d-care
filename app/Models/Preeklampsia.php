<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Preeklampsia extends Model
{
    use HasFactory;
    protected $table = 'preeklampsia';

    protected $fillable = ['pasien','multipara','teknologi_hamil','umur35','nulipara','multipara10','riwayat_preeklampsia','obesitas','multipara_sebelumnya','hamil_multipel','diabetes','hipertensi','ginjal','autoimun','phospholipid','arterial','proteinura','kesimpulan','klaster','poli','kesimpulan'];

    public function pasien()
    {
        return $this->belongsTo(Patients::class, 'pasien', 'id');
    }
}
