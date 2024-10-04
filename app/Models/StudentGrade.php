<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentGrade extends Model
{
    use HasFactory;

    protected $fillable = [
        'batch_id', 'assignment_id', 'enrollee_id', 'grade', 'type', 'remark'
    ];

    public function batch()
    {
        return $this->belongsTo(Batch::class);
    }

    public function assignment()
    {
        return $this->belongsTo(Assignment::class);
    }

    public function enrollee()
    {
        return $this->belongsTo(Enrollee::class);
    }
}
