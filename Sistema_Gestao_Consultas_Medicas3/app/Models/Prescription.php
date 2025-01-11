<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prescription extends Model
{
    use HasFactory;

    protected $table = 'table_prescriptions';

    protected $fillable = [
        'appointment_id',
        'description',
    ];

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }
}
