<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tbc extends Model
{
    use HasFactory;
        protected $table = 'tbc';

    protected $fillable = ['nama', 'tempat_skrining', 'tanggal_lahir','alamat_domisili','alamat_ktp','nik','pekerjaan','jenis_kelamin','no_hp','tinggi_badan','berat_badan','status_gizi','kontak_dengan_pasien','kontak_tbc','jenis_tbc','pernah_berobat_tbc','kapan','pernah_berobat_tbc_tdk_tuntas','kurang_gizi','merokok','perokok_pasif','kencing_manis','odhiv','lansia','ibu_hamil','tinggal_wilayah_kumuh','batuk','durasi','batuk_darah','bb_turun','demam','lesu','pembesaran_kelenjar','sudah_rontgen','hasil_rontgen','terduga_tbc','periksa_tbc_laten', 'klaster','poli','imt','usia'];
}
