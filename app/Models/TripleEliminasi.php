<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TripleEliminasi extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'triple_eliminasi';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'pasien',
        // 'tempat_lahir',
        // 'tanggal_lahir',
        'pekerjaan',
        'status_kawin',
        'gravida',
        'partus',
        'abortus',
        'umur_kehamilan',
        'taksiran_kehamilan',
        'nama_puskesmas',
        'kode_specimen',
        // 'no_hp',
        'umur_ibu',
        // 'alamat',
        'pendidikan',
        'gejala_hepatitis',
        'gejala_urine_gelap',
        'gejala_kuning',
        'gejala_lainnya',
        'test_hepatitis',
        'lokasi_tes',
        'tanggal_tes',
        'anti_hbs',
        'anti_hbc',
        'sgpt',
        'anti_hbe',
        'hbeag',
        'hbv_dna',
        'transfusi_darah',
        'kapan_transfusi',
        'hemodialisa',
        'kapan_hemodialisa',
        'jmlh_pasangan_seks',
        'narkoba',
        'kapan_narkoba',
        'vaksin',
        'kapan_vaksin',
        'jmlh_vaksin',
        'tinggal_serumah',
        'kapan_tinggal_serumah',
        'hubungan_hepatitis',
        'hubungan_detail',
        'test_hiv',
        'hasil_hiv',
        'cd4_check',
        'dimana_cd4',
        'hasil_cd4',
        'arv_check',
        'kapan_arv',
        'gejala_pms',
        'kapan_pms',
        'klaster',
        'poli',
        'kesimpulan'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        // 'tanggal_lahir' => 'date',
        'tanggal_tes' => 'date',
        'kapan_arv' => 'date',
        'kapan_pms' => 'date',
        'gejala_hepatitis' => 'boolean',
        'test_hepatitis' => 'boolean',
        'transfusi_darah' => 'boolean',
        'hemodialisa' => 'boolean',
        'narkoba' => 'boolean',
        'vaksin' => 'boolean',
        'tinggal_serumah' => 'boolean',
        'test_hiv' => 'boolean',
        'cd4_check' => 'boolean',
        'arv_check' => 'boolean',
        'gejala_pms' => 'boolean',
    ];
    public function pasien()
    {
        return $this->belongsTo(Patients::class, 'pasien', 'id');
    }
}
