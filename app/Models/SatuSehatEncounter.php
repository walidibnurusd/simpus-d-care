<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SatuSehatEncounter extends Model
{
    use HasFactory;
    protected $fillable = ['action_id', 'encounter_id'];
}
