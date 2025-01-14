<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Malaria extends Model
{
    use HasFactory;
    protected $table = 'malaria';

    protected $fillable = [
        'pasien',
        'alamat',
        'gejala',
        'jenis_wilayah',
        'tanggal_gejala',
        'hasil_darah',
        'jenis_parasit',
        'riwayat_malaria',
        'waktu',
        'jenis_parasit_malaria',
        'jenis_obat_malaria',
        'tanggal_diagnosis',
        'diagnosis',
        'fasyankes',
        'perawatan',
        'no_rm',
        'metode_diagnosis',
        'jenis_parasit_malaria_sebelumnya',
        'riwayat_tanggal_gejala',
        'riwaya_kasus_malaria',
        'kasus_waktu',
        'kasus_jenis_parasit',
        'kasus_jenis_obat',
        'tanggal_pengobatan',
        'jmlh_obat_dhp',
        'jmlh_obat_primaquin',
        'jmlh_obat_artesunat',
        'jmlh_obat_artemeter',
        'jmlh_obat_kina',
        'jmlh_obat_klindamisin',
        'obat_habis',
        'riwayat_desa_1',
        'riwayat_desa_2',
        'riwayat_desa_3',
        'riwayat_kecamatan_1',
        'riwayat_kecamatan_2',
        'riwayat_kecamatan_3',
        'riwayat_kabupaten_1',
        'riwayat_kabupaten_2',
        'riwayat_kabupaten_3',
        'riwayat_provinsi_1',
        'riwayat_provinsi_2',
        'riwayat_provinsi_3',
        'riwayat_negara_1',
        'riwayat_negara_2',
        'riwayat_negara_3',
        'riwayat_jenis_wilayah_1',
        'riwayat_jenis_wilayah_2',
        'riwayat_jenis_wilayah_3',
        'riwayat_kepentingan_1',
        'riwayat_kepentingan_2',
        'riwayat_kepentingan_3',
        'obat_profilaksis',
        'transfusi_darah',
        'kontak_kasus',
        'import_desa',
        'import_kabupaten',
        'import_provinsi',
        'import_negara',
        'kegiatan1',
        'tempat1',
        'kegiatan2',
        'tempat2',
        'kegiatan3',
        'tempat3',
        'kegiatan4',
        'tempat4',
        'kegiatan5',
        'tempat5',
        'kegiatan6',
        'tempat6',
        'kegiatan_sosial',
        'kabupaten',
        'kecamatan',
        'desa',
        'dusun',
        'tanggal_survey',
        'kolektor',
        'klaster',
        'poli',
        'kesimpulan',
    ];
    public function pasien()
    {
        return $this->belongsTo(Patients::class, 'pasien', 'id');
    }
    public function surveyNyamuk()
    {
        return $this->hasMany(SurveyNyamuk::class, 'malaria');
    }
    public function kelompokMalaria()
    {
        return $this->hasMany(KelompokMalaria::class, 'malaria');
    }
    public function surveyKontak()
    {
        return $this->hasMany(SurveyKontak::class, 'malaria');
    }
}
