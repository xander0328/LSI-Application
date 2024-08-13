<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    protected $fillable = [
        'lesson_id',
        'batch_id',
        'title',
        'points',
        'description',
        'due_date',
        'due_hour',
        'closing',
    ];

    protected $casts = [
        'closing' => 'boolean',
        'closed' => 'boolean',
    ];

    public function batch()
    {
        return $this->belongsTo(Batch::class);
    }

    public function assignment_files()
    {
        return $this->hasMany(AssignmentFile::class);
    }

    public function lesson(){
        return $this->belongsTo(Lesson::class);
    }

    public function temp_turn_in(){
        return $this->hasMany(TempTurnIn::class);
    }
}
