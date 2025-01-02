<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Obesitas extends Model
{
    use HasFactory;
    protected $table = 'obesitas';

    protected $fillable = ['nama','hasil', 'tanggal_lahir', 'tempat_lahir', 'alamat', 'tinggi_badan', 'berat_badan', 'lingkar_peru', 'klaster', 'poli','kesimpulan'];

  
}
