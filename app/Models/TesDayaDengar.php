<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TesDayaDengar extends Model
{
    use HasFactory;

    // The table associated with the model
    protected $table = 'tes_daya_dengar';

    // The attributes that are mass assignable
    protected $fillable = [
        'nama', 
        'tanggal', 
        'jenis_kelamin', 
        'usia', 
        'ekspresif', 
        'reseptif', 
        'visual',
        'poli',
        'klaster'
    ];

    // Cast the JSON columns to arrays
    protected $casts = [
        'ekspresif' => 'array',
        'reseptif' => 'array',
        'visual' => 'array',
    ];

    // The attributes that should be hidden for arrays (optional)
    protected $hidden = [];

    // If you want to treat 'tanggal' as a Carbon instance
    protected $dates = ['tanggal'];
}
