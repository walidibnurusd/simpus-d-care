<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Obat extends Model
{
    use HasFactory;

    protected $table = 'obat';

    protected $fillable = [
        'name','code','shape','amount'
    ];
    
    public function terimaObat()
    {
        return $this->hasMany(TerimaObat::class, 'id_obat');
    }

    protected function shapeLabel(): Attribute
    {
        return Attribute::get(function () {
        $shapes = [
            1 => 'Tablet',
            2 => 'Botol',
            3 => 'Pcs',
            4 => 'Suppositoria',
            5 => 'Ovula',
            6 => 'Drop',
            7 => 'Tube',
            8 => 'Pot',
            9 => 'Injeksi',
        ];

        return $shapes[$this->shape] ?? 'Unknown';
    });

    }

}
