<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Scorecard extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name', 'student_id', 'creator_id', 'diploma_id'
    ];

    public function skills() {
        return $this->belongsToMany(Skill::class)
        ->withPivot('state')
        ->using(ScorecardSkill::class);
    }

    public function student() {
        return $this->belongsTo(Student::class);
    }

    public function creator() {
        return $this->belongsTo(User::class);
    }

    public function diploma() {
        return $this->belongsTo(Diploma::class);
    }

    public function tutor() {
        return $this->creator()->tutor;
    }

}
