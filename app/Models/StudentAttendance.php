<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentAttendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'attendance_id', 'enrollee_id', 'status'
    ];

    public function attendance()
    {
        return $this->belongsTo(Attendance::class);
    }

    public function enrollee()
    {
        return $this->belongsTo(Enrollee::class);
    }
}
