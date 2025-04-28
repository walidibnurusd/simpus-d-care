<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Merokok extends Model
{
    use HasFactory;

       protected $table = 'merokok';

    protected $fillable = [
        'no_kuesioner',
        'sekolah',
        'provinsi',
        'puskesmas',
        'petugas',
        'pasien',
        // 'nik',
        // 'tanggal_lahir',
        'umur',
        // 'jenis_kelamin',
        'merokok',
        'jenis_rokok',
        'jenis_rokok_lainnya',
        'usia_merokok',
        'alasan_merokok',
        'alasan_merokok_lainnya',
        'batang_per_hari',
        'batang_per_minggu',
        'lama_merokok_minggu',
        'lama_merokok_bulan',
        'lama_merokok_tahun',
        'dapat_rokok',
        'dapat_rokok_lainnya',
        'berhenti_merokok',
        'alasan_berhenti_merokok',
        'alasan_berhenti_merokok_lainnya',
        'tau_bahaya_rokok',
        'melihat_orang_merokok',
        'orang_merokok',
        'orang_merokok_lainnya',
        'anggota_keluarga_merokok',
        'teman_merokok',
        'periksa_co2',
        'kadar_co2',
        'klaster',
        'poli',
        'kesimpulan'
    ];
    protected $casts = [
        'jenis_rokok' => 'array',
        'alasan_merokok' => 'array',
        'dapat_rokok' => 'array',
        'orang_merokok' => 'array',
        'alasan_berhenti_merokok' => 'array',
    ];
    // Jika ingin melindungi field tertentu, gunakan $guarded
    // protected $guarded = ['id'];
    public function listPasien()
    {
        return $this->belongsTo(Patients::class, 'pasien', 'id');
    }
}
