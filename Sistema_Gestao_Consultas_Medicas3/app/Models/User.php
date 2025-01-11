<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'table_users';

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',  // Enum field
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
    
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
}