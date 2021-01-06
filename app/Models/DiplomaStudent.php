<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;

class DiplomaStudent extends Pivot
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'diploma_id', 'student_id', 'start_year', 'end_year','state'
    ];

    const OBTAINED = 'obtained';
    const IN_PROGRESS = 'in_progress';
    const FAILED = 'failed';

    public function diploma() {
        return $this->belongsTo(Diploma::class, 'diploma_id');
    }

    public function student() {
        return $this->belongsTo(Student::class, 'student_id');
    }
}
