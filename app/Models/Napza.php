<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Napza extends Model
{
    use HasFactory;
    protected $table = 'napza';

    protected $fillable = ['pasien', 'nama_dokter', 'klinik', 'pertanyaan1', 'nama_zat_lain','pertanyaan2', 'pertanyaan3', 'pertanyaan4', 'pertanyaan5', 'pertanyaan6', 'pertanyaan7', 'pertanyaan8', 'klaster', 'poli','kesimpulan'];

    protected $casts = [
        'pertanyaan1' => 'array',
        'pertanyaan2' => 'array',
        'pertanyaan3' => 'array',
        'pertanyaan4' => 'array',
        'pertanyaan5' => 'array',
        'pertanyaan6' => 'array',
        'pertanyaan7' => 'array',
        'pertanyaan8' => 'array',
    ];
    public function listPasien()
    {
        return $this->belongsTo(Patients::class, 'pasien', 'id');
    }
}
