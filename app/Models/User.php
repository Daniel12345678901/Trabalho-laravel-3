<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    protected $table = 'table_users';

    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Relationship with Role model
    public function role()
    {
        return $this->belongsTo(Role::class);
    }
    
    // Relationship with Doctor model (has one Doctor profile)
    public function doctor()
    {
        return $this->hasOne(Doctor::class);
    }

    // Relationship with Patient model (has one Patient profile)
    public function patient()
    {
        return $this->hasOne(Patient::class);
    }

    // JWT implementation in the user
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}