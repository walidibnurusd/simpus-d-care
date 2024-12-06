<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    use HasFactory;

    protected $table = 'user_details';

    protected $fillable = [
        'user_id',
        'nip',
        'employee_name',
        'phone_wa',
        'gender',
        'region',
        'marrital_status',
        'place_of_birth',
        'date_of_birth',
        'current_address',
        'education',
        'profession',
        'employee_status',
        'position',
        'rank',
        'tmt_pangkat',
        'group',
        'tmt_golongan',
        'photo',
    ];

    /**
     * Get the user associated with the user detail.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the gender associated with the user detail.
     */
    public function genders()
    {
        return $this->belongsTo(Gender::class, 'gender');
    }


    /**
     * Get the region associated with the user detail.
     */
    public function religions()
    {
        return $this->belongsTo(Religion::class,'religion');
    }

    /**
     * Get the marital status associated with the user detail.
     */
    public function marritalStatuss()
    {
        return $this->belongsTo(MarritalStatus::class,'marrital_status');
    }

    /**
     * Get the education associated with the user detail.
     */
    public function educations()
    {
        return $this->belongsTo(Education::class, 'education');
    }

    /**
     * Get the profession associated with the user detail.
     */
    public function professions()
    {
        return $this->belongsTo(Profession::class,'profession');
    }

    /**
     * Get the employee status associated with the user detail.
     */
    public function employeeStatuss()
    {
        return $this->belongsTo(EmployeeStatus::class,'employee_status');
    }

    /**
     * Get the position associated with the user detail.
     */
    public function positions()
    {
        return $this->belongsTo(Position::class,'position');
    }

    /**
     * Get the rank associated with the user detail.
     */
    public function ranks()
    {
        return $this->belongsTo(Rank::class,'rank');
    }

    /**
     * Get the group associated with the user detail.
     */
    public function groups()
    {
        return $this->belongsTo(Group::class,'group');
    }
}
