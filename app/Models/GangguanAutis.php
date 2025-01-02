<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GangguanAutis extends Model
{
    use HasFactory;
    protected $table = 'gangguan_autis';

    protected $fillable = ['pasien', 'lihat_objek', 'tuli', 'main_pura_pura', 'suka_manjat', 'gerakan_jari', 'tunjuk_minta', 'tunjuk_menarik', 'tertarik_anak_lain', 'membawa_benda', 'respon_nama_dipanggil', 'respon_senyum', 'pernah_marah', 'bisa_jalan', 'menatap_mata', 'meniru', 'memutar_kepala', 'melihat', 'mengerti', 'menatap_wajah', 'suka_bergerak', 'klaster', 'poli','kesimpulan'];
    public function listPasien()
    {
        return $this->belongsTo(Patients::class, 'pasien', 'id');
    }
}
