<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Diploma extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name', 'creator_id'
    ];

    public function scorecards() {
        return $this->hasMany(Scorecard::class);
    }

    public function students() {
        return $this->belongsToMany(Student::class)
        ->using(DiplomaStudent::class);
    }

    public function creator() {
        return $this->belongsTo(User::class);
    }

    public function skillTemplates() {
        return $this->belongsToMany(SkillTemplate::class)
        ->using(DiplomaSkillTemplate::class);
    }

}
