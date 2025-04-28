<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TerimaObat extends Model
{
    use HasFactory;

       protected $table = 'terima_obat';

    protected $fillable = [
        'id_obat','amount','date'
    ];
     public function obat()
    {
        return $this->belongsTo(Obat::class, 'id_obat');
    }
}
