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
        'pasien', 
        // 'tanggal', 
        // 'jenis_kelamin', 
        'usia', 
        'ekspresif', 
        'reseptif', 
        'visual',
        'poli',
        'klaster',
        'kesimpulan'
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
    public function listPasien()
    {
        return $this->belongsTo(Patients::class, 'pasien', 'id');
    }
}
