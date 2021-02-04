<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use phpDocumentor\Reflection\Types\Boolean;

class Tutor extends Model
{

    use HasFactory, SoftDeletes;

    protected $fillable = [
        'company_id', 'user_id'
    ];

    protected $with = ['user', 'company'];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function students()
    {
        return $this->hasMany(Student::class);
    }

    public function scorecards()
    {
        return $this->hasMany(Scorecard::class);
    }

    public function debriefs()
    {
        return $this->hasMany(Debrief::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }



    
}
