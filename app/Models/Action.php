<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Action extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_patient',
        'tanggal',
        'doctor',
        'kunjungan',
        'faskes',
        'sistol',
        'diastol',
        'beratBadan',
        'tinggiBadan',
        'lingkarPinggang',
        'riwayat_penyakit_sekarang',
        'riwayat_penyakit_dulu',
        'riwayat_penyakit_lainnya',
        'riwayat_penyakit_keluarga',
        'riwayat_penyakit_lainnya_keluarga',
        'riwayat_alergi',
        'riwayat_pengobatan',
        'keluhan',
        'diagnosa',
        'tindakan',
        'rujuk_rs',
        'keterangan',
        'nadi',
        'nafas',
        'suhu',
        'mata_anemia',
        'pupil',
        'ikterus',
        'udem_palpebral',
        'nyeri_tekan',
        'peristaltik',
        'ascites',
        'lokasi_abdomen',
        'thorax',
        'thorax_bj',
        'paru',
        'suara_nafas',
        'ronchi',
        'wheezing',
        'ekstremitas',
        'edema',
        'tonsil',
        'fharing',
        'kelenjar',
        'genetalia',
        'warna_kulit',
        'turgor',
        'neurologis',
        'hasil_lab',
        'hamil',
        'tipe',
        'icd10',
        'oralit',
        'zinc',
        'obat',
        'pemeriksaan_penunjang',
        'usia_kehamilan',
        'jenis_anc',
        'lingkar_lengan_atas',
        'tinggi_fundus_uteri',
        'presentasi_janin',
        'denyut_jantung',
        'kaki_bengkak',
        'imunisasi_tt',
        'tablet_fe',
        'gravida',
        'partus',
        'abortus',
        'proteinuria',
        'hiv',
        'sifilis',
        'hepatitis',
        'periksa_usg',
        'hasil_usg',
        'treatment_anc',
        'tanggal_kembali',
        'kesimpulan',
        'nilai_hb',
        'layanan_kb',
        'jmlh_anak_laki',
        'jmlh_anak_perempuan',
        'status_kb',
        'tgl_lahir_anak_bungsu',
        'kb_terakhir',
        'tgl_kb_terakhir',
        'kedaaan_umum',
        'informed_concern',
        'sakit_kuning',
        'pendarahan_vagina',
        'tumor',
        'diabetes',
        'pembekuan_darah',
        'update_obat',
        'beri_tindakan',
        'tindakan_ruang_tindakan',
        'kasus','alergi', 'gangguan_ginjal', 'menyusui',
        'verifikasi_awal', 'verifikasi_akhir', 'informasi_obat', 'id_rujuk_poli','diagnosa_primer','status_satu_sehat'
    ];

    protected $casts = [
        'diagnosa' => 'array',
        'verifikasi_awal' => 'array', 'verifikasi_akhir' => 'array', 'informasi_obat' => 'array',
    ];
    /**
     * Relasi ke model Patient
     */
    public function patient()
    {
        return $this->belongsTo(Patients::class, 'id_patient');
    }
    public function hasilLab()
    {
        return $this->hasOne(HasilLab::class, 'id_action','id');
    }
    /**
     * Relasi ke model Doctor
     */
    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'id_doctor');
    }

    /**
     * Relasi ke model Disease (Riwayat Penyakit Keluarga)
     */
    public function diseaseFamilyHistory()
    {
        return $this->belongsTo(Disease::class, 'riwayat_penyakit_keluarga');
    }

    /**
     * Relasi ke model Disease (Riwayat Penyakit Tidak Menular)
     */
    public function diseaseNonCommunicableHistory()
    {
        return $this->belongsTo(Disease::class, 'riwayat_penyakit_tidak_menular');
    }
     public function rujukPoli()
    {
        return $this->belongsTo(Poli::class, 'id_rujuk_poli');
    }

    /**
     * Relasi ke model Diagnosis
     */
    // public function diagnosis()
    // {
    //     return $this->belongsToMany(Diagnosis::class, 'diagnosa');
    // }

    /**
     * Relasi ke model Hospital (Rujukan Rumah Sakit)
     */
    public function hospitalReferral()
    {
        return $this->belongsTo(Hospital::class, 'rujuk_rs');
    }
    public function actionObats()
    {
        return $this->hasMany(ActionObat::class, 'id_action');
    }
    public function diagnosaPrimer()
    {
        return $this->belongsTo(Diagnosis::class, 'diagnosa_primer');
    }

	public function satuSehatEncounter() {
		return $this->hasOne(SatuSehatEncounter::class);
	}
}
