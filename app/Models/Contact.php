<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'firstname', 'lastname', 'function', 'phone', 'email', 'school_id'
    ];

    public function school() {
        return $this->hasOne(School::class);
    }

    public function debriefs() {
        return $this->hasMany(Debrief::class);
    }
}
