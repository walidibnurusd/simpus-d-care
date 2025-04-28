<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GangguanJiwaRemaja extends Model
{
    use HasFactory;
    protected $table = 'gangguan_jiwa_remaja';

    protected $fillable = ['pasien', 'peduli_perasaan', 'gelisah', 'sakit', 'berbagi', 'marah', 'suka_sendiri', 'penurut', 'cemas', 'siap_menolong', 'badan_bergerak', 'punya_teman', 'suka_bertengkar', 'tdk_bahagia', 'disukai', 'mudah_teralih', 'gugup', 'baik_pada_anak', 'bohong', 'suka_bantu', 'kritis', 'mencuri', 'mudah_berteman', 'takut', 'rajin', 'klaster', 'poli','kesimpulan','diancam','berusaha_baik'];
    public function listPasien()
    {
        return $this->belongsTo(Patients::class, 'pasien', 'id');
    }
}
