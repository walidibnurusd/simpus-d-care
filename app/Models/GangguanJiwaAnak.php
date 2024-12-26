<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GangguanJiwaAnak extends Model
{
    use HasFactory;
    protected $table = 'gangguan_jiwa_anak';

    protected $fillable = ['nama', 'tanggal_lahir', 'jenis_kelamin', 'alamat', 'berusaha_baik', 'gelisah', 'sakit', 'berbagi', 'marah', 'suka_sendiri', 'penurut', 'cemas', 'siap_menolong', 'badan_bergeral', 'punya_teman', 'suka_bertengkar', 'tdk_bahagia', 'disukai', 'mudah_teralih', 'gugup', 'baik_pada_anak', 'bohong', 'suka_bantu', 'kritis', 'mencuri', 'mudah_berteman', 'takut', 'rajin', 'klaster', 'poli'];
}
