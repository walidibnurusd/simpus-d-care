<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengeluaranObatLain extends Model
{
    use HasFactory;

       protected $table = 'pengeluaran_obat_lain';

    protected $fillable = [
        'id_obat','amount','date'
    ];
     public function obat()
    {
        return $this->belongsTo(Obat::class, 'id_obat');
    }
}
