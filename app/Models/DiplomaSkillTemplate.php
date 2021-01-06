<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;

class DiplomaSkillTemplate extends Pivot
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'skill_template_id', 'diploma_id'
    ];

    public function skillTemplate() {
        return $this->belongsTo(SkillTemplate::class, 'skill_template_id');
    }

    public function diploma() {
        return $this->belongsTo(Diploma::class, 'diploma_id');
    }
}
