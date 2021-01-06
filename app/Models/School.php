<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class School extends Model
{

    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name', 'address_id', 'logo'
    ];

    public function students() {
        return $this->hasMany(Student::class);
    }

    public function contacts() {
        return $this->hasMany(Contact::class);
    }

    public function address() {
        return $this->belongsTo(Address::class);
    }
}
