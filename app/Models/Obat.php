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
            10 => 'Kapsul',
            11 => 'Ampul',
            12 => 'Sachet',
            13 => 'Paket',
            14 => 'Vial',
            15 => 'Bungkus',
            16 => 'Strip',
            17 => 'Test',
            18 => 'Lbr',
            19 => 'Tabung',
            20 => 'Buah',
            21 => 'Lembar',
        ];

        return $shapes[$this->shape] ?? 'Unknown';
    });

    }

}
