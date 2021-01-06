<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Skill extends Model
{

    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name', 'skill_template_id', 'creator_id'
    ];

    public function scorecards() {
        return $this->belongsToMany(Scorecard::class)
        ->withPivot('state')
        ->using(ScorecardSkill::class);
    }

    public function skillTemplate() {
        return $this->belongsTo(skillTemplate::class);
    }

    public function creator() {
        return $this->belongsTo(User::class);
    }
}
