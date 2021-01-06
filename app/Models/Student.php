<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'school_id', 'user_id', 'address_id', 'tutor_id', 'active'
    ];

    protected $with = [
        'school', 'user', 'address', 'tutor'
    ];

    public function school() {
        return $this->belongsTo(School::class);
    }

    /**
     * diplomas
     *
     * @return BelongsToMany
     */
    public function diplomas(): BelongsToMany {
        return $this->belongsToMany(Diploma::class)
        ->using(DiplomaStudent::class)
        ->withPivot('year', 'created_at')
        ->orderBy('year', 'desc');
    }

    public function scorecards() {
        return $this->hasMany(Scorecard::class);
    }

    public function tutor() {
        return $this->belongsTo(Tutor::class);
    }

    public function documents() {
        return $this->hasMany(Document::class);
    }

    public function debriefs() {
        return $this->hasMany(Debrief::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function address() {
        return $this->belongsTo(Address::class);
    }

    public function isActive() {
        return $this->isActive();
    }

}
