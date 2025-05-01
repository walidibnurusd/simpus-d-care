<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GangguanJiwaDewasa extends Model
{
    use HasFactory;
    protected $table = 'gangguan_jiwa_dewasa';

    protected $fillable = ['pasien', 'sakit_kepala','hilang_nafsu_makan' ,'tidur_nyeyak', 'takut', 'cemas', 'tangan_gemetar', 'gangguan_pencernaan', 'sulit_berpikir_jernih', 'tdk_bahagia', 'sering_menangis', 'sulit_aktivitas', 'sulit_ambil_keputusan', 'tugas_terbengkalai', 'tdk_berperan', 'hilang_minat', 'tdk_berharga', 'pikiran_mati', 'lelah_selalu', 'sakit_perut', 'mudah_lelah', 'klaster', 'poli', 'kesimpulan'];
    public function pasien()
    {
        return $this->belongsTo(Patients::class, 'pasien', 'id');
    }
}
