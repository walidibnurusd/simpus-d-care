<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Occupation extends Model
{
    use HasFactory;

    protected $table = 'occupations';

    protected $fillable = ['name'];

public function respondent()
    {
        return $this->hasMany(Respondent::class, 'id_occupation');
    }
 
}
