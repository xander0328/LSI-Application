<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TurnIn extends Model
{
    protected $fillable = [
        'enrollee_id', 'assignment_id', 'turned_in', 'turned_in_date'
    ];

    public function assignment()
    {
        return $this->belongsTo(Assignment::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function enrollee(){
        return $this->belongsTo(Enrollee::class);
    }

    public function turn_in_files(){
        return $this->hasMany(TurnInFile::class);
    }

    public function turn_in_links(){
        return $this->hasMany(TurnInLink::class);
    }

    public function isLate()
    {
        // Get the assignment associated with the turn-in
        $assignment = $this->assignment;

        // If there's no assignment associated, return null or handle accordingly
        if (!$assignment) {
            return null;
        }

        // Check if due_date and due_hour are null
        if (is_null($assignment->due_date) || is_null($assignment->due_hour)) {
            // If either is null, consider it as no deadline (not late)
            return false;
        }

        // Combine the due_date and due_hour fields into a single DateTime
        $dueDateTime = Carbon::parse($assignment->due_date . ' ' . $assignment->due_hour);

        // Check if the turned_in_date is after the due date and time
        return Carbon::parse($this->turned_in_date)->greaterThan($dueDateTime);
    }
}
