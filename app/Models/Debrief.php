<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Debrief extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'date', 'summary', 'student_id', 'tutor_id', 'contact_id'
    ];

    public function tutor() {
        return $this->belongsTo(Tutor::class);
    }

    public function student() {
        return $this->belongsTo(Student::class);
    }

    public function contact() {
        return $this->belongsTo(Contact::class);
    }

    public function documents() {
        return $this->hasMany(Document::class);
    }
}
