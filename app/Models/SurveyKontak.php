<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveyKontak extends Model
{
    use HasFactory;
    protected $table = 'survey_kontak';

    protected $fillable = ['malaria','nama','umur','jenis_kelamin','hub_kasus','alamat','tgl_pengambilan_darah','tgl_diagnosis','hasil_pemeriksaan'];

    public function malaria()
    {
        return $this->belongsTo(Malaria::class, 'malaria', 'id');
    }
}
