<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KankerKolorektal extends Model
{
    use HasFactory;

    protected $table = 'kanker_kolorektal';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        // 'nama',
        // 'tanggal',
        // 'jenis_kelamin',
        'pasien',
        'usia',
        'riwayat_kanker',
        'merokok',
        'bercampur_darah',
        'diare_kronis',
        'bab_kambing',
        'konstipasi_kronis',
        'frekuensi_defekasi',
        'klaster',
        'poli',
    ];
    public function listPasien()
    {
        return $this->belongsTo(Patients::class, 'pasien', 'id');
    }
}
