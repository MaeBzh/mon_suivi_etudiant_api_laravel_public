<?php

namespace App\Models;

use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, CanResetPassword, MustVerifyEmail;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'firstname', 'lastname', 'email', 'password', 'phone', 'is_admin'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'is_admin' => 'boolean',
        'email_verified_at' => 'datetime',
    ];

    public function student() {
        return $this->hasOne(Student::class);
    }

    public function tutor() {
        return $this->hasOne(Tutor::class);
    }

    public function isAdmin() {
        return $this->is_admin;
    }

    public function isTutor() {
        return $this->tutor()->exists();
    }

    public function scopeAdmin(Builder $query){
        return $query->where('is_admin', true);
    }

    public function scopeIsStudent(Builder $query){
        return $query->has('student');
    }

    protected function createRememberToken() {
        return $this->getAuthIdentifier() . '|' . $this->getRememberToken() . '|' . $this->getAuthPassword();
    }

    public function generateAuthResponse(bool $remember = false) {
        $data = [
            'status_code' => 200,
            'access_token' => $this->createToken('authToken')->plainTextToken,
            'token_type' => 'Bearer',
            'connected_user' => $this->tutor
        ];

        if ($remember) {
            $data['remember'] = $this->createRememberToken();
        }

        return response()->json($data);
    }
}
