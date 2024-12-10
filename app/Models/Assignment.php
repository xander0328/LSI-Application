<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

class Assignment extends Model
{
    use SoftDeletes;

    protected $appends = ['formattedDue'];

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

    public function getFormattedDueAttribute()
    {
        if ($this->due_date === null || $this->due_hour === null) {
            return null; // Return null if either due_date or due_hour is null
        }

        // Parse the due_date and due_hour together into a Carbon instance
        $dueDateTime = Carbon::parse($this->due_date . ' ' . $this->due_hour);

        // Format and return the datetime as a string
        return $dueDateTime->format('Y-m-d H:i:s');
    }

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

    public function student_grade(){
        return $this->hasOne(StudentGrade::class);
    }

    public function student_grades(){
        return $this->hasMany(StudentGrade::class);
    }

    public function turn_ins(){
        return $this->hasOne(TurnIn::class);
    }
}
