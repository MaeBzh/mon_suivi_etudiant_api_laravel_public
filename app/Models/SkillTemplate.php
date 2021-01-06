<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SkillTemplate extends Model
{

    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name', 'creator_id'
    ];

    public function diplomas() {
        return $this->belongsToMany(Diploma::class)
        ->using(DiplomaSkillTemplate::class);
    }

    public function creator() {
        return $this->belongsTo(User::class);
    }
}
