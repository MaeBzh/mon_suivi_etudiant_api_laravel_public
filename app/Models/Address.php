<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Address extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'address1', 'address2', 'zipcode', 'city'
    ];

    public function user() {
        return $this->hasOne(User::class);
    }

    public function school() {
        return $this->hasOne(School::class);
    }

    public function company() {
        return $this->hasOne(Company::class);
    }

    public function student() {
        return $this->hasOne(Student::class);
    }
}
