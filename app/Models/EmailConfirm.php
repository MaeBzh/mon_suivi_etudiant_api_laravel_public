<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Str;

class EmailConfirm extends Model
{
    use HasFactory;

    protected $fillable = [
        'email', 'token', 'url'
    ];

    public $timestamps = false;

    public function generateToken() {
        return Str::random(60);
    }
}
