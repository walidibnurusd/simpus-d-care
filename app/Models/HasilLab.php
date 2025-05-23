<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HasilLab extends Model
{
    use HasFactory;

    protected $table = 'hasil_labs';
    protected $fillable = [
        'id_action',
        'jenis_pemeriksaan',
        'gds',
        'gdp',
        'gdp_2_jam_pp',
        'cholesterol',
        'asam_urat',
        'leukosit',
        'eritrosit',
        'trombosit',
        'hemoglobin',
        'sifilis',
        'hiv',
        'golongan_darah',
        'widal',
        'malaria',
        'albumin',
        'reduksi',
        'urinalisa',
        'tes_kehamilan',
        'telur_cacing',
        'bta',
        'igm_dbd',
        'igm_typhoid',
        'tcm',
    ];
    protected $casts = [
        'jenis_pemeriksaan' => 'array',
    ];
    
    /**
     * Relasi ke model Action
     */
    public function actions()
    {
        return $this->belongsTo(Action::class, 'id_action');
    }
}
