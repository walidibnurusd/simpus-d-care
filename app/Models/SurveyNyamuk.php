<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveyNyamuk extends Model
{
    use HasFactory;
    protected $table = 'survey_nyamuk';

    protected $fillable = ['malaria','habitat','ph','sal','suhu','kond','kept','dasar','air','sktr','teduh','predator','larve_an','larva_cx','jarak_kamp','klp_habitat','gps','catatan'];

    public function malaria()
    {
        return $this->belongsTo(Malaria::class, 'malaria', 'id');
    }
}
