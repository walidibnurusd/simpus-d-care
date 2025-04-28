<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravolt\Indonesia\Models\Village;

class Patients extends Model
{
    use HasFactory;
    protected $table = 'patients';

    protected $fillable = ['nik', 'name', 'dob', 'place_birth', 'gender', 'phone', 'marrital_status', 'no_rm', 'blood_type', 'occupation', 'education', 'address', 'rw', 'indonesia_province_id', 'indonesia_city_id', 'indonesia_district', 'indonesia_village', 'jenis_kartu', 'nomor_kartu', 'klaster', 'poli','kunjungan','wilayah_faskes','no_family_folder'];

    /**
     * Get the patient's age from their date of birth.
     *
     * @return int
     */
    public function getAgeAttribute()
    {
        return \Carbon\Carbon::parse($this->dob)->age;
    }
    public function marritalStatus()
    {
        return $this->belongsTo(MarritalStatus::class, 'marrital_status', 'id');
    }
    public function genderName()
    {
        return $this->belongsTo(Gender::class, 'gender', 'id');
    }
    public function educations()
    {
        return $this->belongsTo(Education::class, 'education', 'id');
    }
    public function occupations()
    {
        return $this->belongsTo(Occupation::class, 'occupation', 'id');
    }
    public function kunjungans()
    {
        return $this->hasMany(Kunjungan::class, 'pasien', 'id');
    }
    public function actions()
    {
        return $this->hasMany(Action::class, 'id_patient', 'id');
    }
    
}
