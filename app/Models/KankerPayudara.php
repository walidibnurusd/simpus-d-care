<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KankerPayudara extends Model
{
    use HasFactory;

    /**
     * Tabel terkait model.
     *
     * @var string
     */
    protected $table = 'kanker_payudara';

    /**
     * Kolom yang dapat diisi secara massal.
     *
     * @var array
     */
    protected $fillable = [
        'nomor_klien',
        'pasien',
        'umur',
        'suku_bangsa',
        'agama',
        'berat_badan',
        'tinggi_badan',
        // 'alamat',
        'perkawinan_pasangan',
        'klien',
        'pekerjaan_klien',
        'pekerjaan_suami',
        'pendidikan_terakhir',
        'jmlh_anak_kandung',
        'rt_rw',
        'kelurahan_desa',
        'menstruasi',
        'usia_seks',
        'keputihan',
        'merokok',
        'terpapar_asap_rokok',
        'konsumsi_buah_sayur',
        'konsumsi_makanan_lemak',
        'konsumsi_makanan_pengawet',
        'kurang_aktivitas',
        'pap_smear',
        'berganti_pasangan',
        'riwayat_kanker',
        'jenis_kanker',
        'kehamilan_pertama',
        'menyusui',
        'melahirkan',
        'melahirkan_4_kali',
        'menikah_lbh_1',
        'kb_hormonal_pil',
        'kb_hormonal_suntik',
        'tumor_jinak',
        'menopause',
        'obesitas',
        'kulit',
        'areola',
        'benjolan',
        'ukuran_benjolan',
        'normal',
        'kelainan_jinak',
        'kelainan_ganas',
        'vulva',
        'vulva_details',
        'vagina',
        'vagina_details',
        'serviks',
        'serviks_details',
        'uterus',
        'uterus_details',
        'adnexa',
        'adnexa_details',
        'rectovaginal',
        'rectovaginal_details',
        'iva_negatif',
        'iva_positif',
        'tanggal_kunjungan',
        'lainnya',
        'ims',
        'detail_diobati',
        'dirujuk',
        'rujukan',
        'klaster',
        'poli',
        'kesimpulan'
    ];
    
    protected $casts = [
        'kulit' => 'array',
        'areola' => 'array',
        'normal' => 'array',
        'kelainan_jinak' => 'array',
        'kelainan_ganas' => 'array',
        'iva_negatif' => 'array',
        'iva_positif' => 'array',
        'ims' => 'array',
        'rujukan' => 'array',
   
    ];
    public function listPasien()
    {
        return $this->belongsTo(Patients::class, 'pasien', 'id');
    }

}
