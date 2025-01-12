<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $table = 'table_appointments';

    protected $fillable = [
        'doctor_id',
        'patient_id',
        'room_id',
        'schedule_id',
        'date_time',
        'status',
    ];

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }
}