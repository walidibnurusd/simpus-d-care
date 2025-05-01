<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KelompokMalaria extends Model
{
    use HasFactory;
    protected $table = 'kelompok_malaria';

    protected $fillable = ['malaria','nama','alamat'];

    public function malaria()
    {
        return $this->belongsTo(Malaria::class, 'malaria', 'id');
    }
}
