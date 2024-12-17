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
        'id_doctor',
        'kunjungan',
        'kartu',
        'nomor',
        'faskes',
        'sistol',
        'diastol',
        'beratBadan',
        'tinggiBadan',
        'lingkarPinggang',
        'gula',
        'merokok',
        'fisik',
        'garam',
        'gula_lebih',
        'lemak',
        'alkohol',
        'hidup',
        'buah_sayur',
        'hasil_iva',
        'tindak_iva',
        'hasil_sadanis',
        'tindak_sadanis',
        'konseling',
        'car',
        'rujuk_ubm',
        'kondisi',
        'edukasi',
        'riwayat_penyakit_keluarga',
        'riwayat_penyakit_tidak_menular',
        'keluhan',
        'diagnosa',
        'tindakan',
        'rujuk_rs',
        'keterangan',
    ];

    /**
     * Relasi ke model Patient
     */
    public function patient()
    {
        return $this->belongsTo(Patients::class, 'id_patient');
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

    /**
     * Relasi ke model Diagnosis
     */
    public function diagnosis()
    {
        return $this->belongsTo(Diagnosis::class, 'diagnosa');
    }

    /**
     * Relasi ke model Hospital (Rujukan Rumah Sakit)
     */
    public function hospitalReferral()
    {
        return $this->belongsTo(Hospital::class, 'rujuk_rs');
    }
}
