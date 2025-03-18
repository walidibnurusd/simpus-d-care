<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActionObat extends Model
{
    use HasFactory;
    protected $table = 'action_obat';

    protected $fillable = ['id_action','id_obat','dose','amount','shape'];
  

}
