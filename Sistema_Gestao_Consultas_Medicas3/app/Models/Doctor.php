<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    protected $table = 'table_doctors';

    protected $fillable = [
        'user_id',
        'phone_number',
        'specialization_summary',
    ];

    // Relationship with User model
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    // Relationship with specialties (many-to-many)
    public function specialties()
    {
        return $this->belongsToMany(Specialty::class, 'table_doctor_specialty', 'doctor_id', 'specialty_id');
    }
}