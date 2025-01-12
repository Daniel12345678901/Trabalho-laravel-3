<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Specialty extends Model
{
    use HasFactory;

    protected $table = 'table_specialties';

    protected $fillable = [
        'name',
    ];

    // Relationship with doctors (many-to-many)
    public function doctors()
    {
        return $this->belongsToMany(Doctor::class, 'doctor_specialty', 'specialty_id', 'doctor_id');
    }
}