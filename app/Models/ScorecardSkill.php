<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;

class ScorecardSkill extends Pivot
{

    use HasFactory, SoftDeletes;

    protected $fillable = [
        'skill_id', 'scorecard_id', 'state'
    ];

    const NOT_SEEN = 'not_seen';
    const IN_PROGRESS = 'in_progress';
    const MASTERED = 'mastered';

    public function skill() {
        return $this->belongsTo(Skill::class, 'skill_id');
    }

    public function scorecard() {
        return $this->belongsTo(Scorecard::class, 'scorecard_id');
    }
}
