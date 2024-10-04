<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'batch_id', 'date', 'mode'
    ];

    public function batch()
    {
        return $this->belongsTo(Batch::class);
    }

    public function student_attendance()
    {
        return $this->hasOne(StudentAttendance::class);
    }
}
