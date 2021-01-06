<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Document extends Model
{

    use HasFactory, SoftDeletes;

    protected $fillable = [
        'filename', 'relative_path', 'extension', 'disk', 'document_type_id', 'debrief_id', 'student_id'
    ];

    public function documentType() {
        return $this->belongsTo(DocumentType::class);
    }

    public function student() {
        return $this->belongsTo(Student::class);
    }

    public function debrief() {
        return $this->belongsTo(Debrief::class);
    }
}
