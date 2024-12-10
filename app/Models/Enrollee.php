<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Notifications\Notifiable;

class Enrollee extends Model
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $dates = ['birth_date','preferred_start', 'preferred_finish'];

    protected $fillable = [
        'user_id',
        'course_id',
        'batch_id',
        'completed_at',
        'id_picture',
        'street',
        'created_at',
        'updated_at',
        'barangay',
        'district',
        'city',
        'province',
        'region',
        'zip',
        'box_no',
        'sex',
        'civil_status',
        'telephone',
        'cellular',
        'email',
        'employment_type',
        'employment_status',
        'birth_date',
        'birth_place',
        'citizenship',
        'religion',
        'height',
        'weight',
        'blood_type',
        'sss',
        'gsis',
        'tin',
        'disting_marks',
        'preferred_schedule',
        'preferred_start',
        'preferred_finish'
    ];

    private const PASSING_ATTENDANCE_PERCENTAGE = 0.8;
    private const PASSING_ASSIGNMENT_PERCENTAGE = 0.8;
    private const PASSING_AVERAGE_SCORE = 80;


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function batch()
    {
        return $this->belongsTo(Batch::class);
    }

    public function enrollee_files()
    {
        return $this->hasMany(EnrolleeFile::class);
    }

    public function enrollee_files_submitted()
    {
        return $this->hasMany(EnrolleeFile::class)->whereNotNull('submitted');
    }

    public function enrollee_education()
    {
        return $this->hasMany(Education::class);
    }

    public function enrollee_grades(){
        return $this->hasOne(StudentGrade::class);
    }

    public function grades()
    {
        return $this->hasMany(StudentGrade::class);
    }

    public function turn_ins() {
        return $this->hasMany(TurnIn::class);
    }

    public function enrollee_turn_in() {
        return $this->hasOne(TurnIn::class);
    }

    public function payments() {
        return $this->hasMany(Payment::class);
    }

    public function payment() {
        return $this->hasOne(Payment::class);
    }

    public function assignment(){
        return $this->hasMany(Assignment::class);
    }

    public function enrollee_attendances(){
        return $this->hasMany(StudentAttendance::class);
    }

    public function hasPassedCourse()
    {
        // Get batch and course details
        $course = $this->batch->course;

        $totalSessions = StudentAttendance::whereHas('attendance', function ($query) {
            $query->where('batch_id', $this->batch->id);
        })->where('enrollee_id', $this->id)->count();
        // Calculate attendance rate
        $attendedSessions = StudentAttendance::whereHas('attendance', function ($query) {
            $query->where('batch_id', $this->batch->id);
        })->where('enrollee_id', $this->id)
            ->sum(DB::raw("CASE WHEN status = 'present' THEN 1 WHEN status = 'late' THEN 0.5 ELSE 0 END"));

        $attendanceRate = $totalSessions > 0 ? $attendedSessions / $totalSessions : 0;

        // Calculate assignment completion rate
        $totalAssignments = $this->batch->assignment()->count();

        $completedAssignments = StudentGrade::where('batch_id', $this->batch->id)
        ->where('enrollee_id', $this->id)
        ->whereNotNull('grade')
        ->whereNot('grade', 0)
        ->count();

        $assignmentRate = $totalAssignments > 0 ? $completedAssignments / $totalAssignments : 0;

        // 3. Calculate Average Score
        $averageScore = $this->grades()->avg('grade');

        // Check if all criteria are met
        return $attendanceRate >= self::PASSING_ATTENDANCE_PERCENTAGE &&
            $assignmentRate >= self::PASSING_ASSIGNMENT_PERCENTAGE &&
            $averageScore >= self::PASSING_AVERAGE_SCORE;
        // return $assignmentRate;
    }

    public function getOverallRating()
    {
        $course = $this->batch->course;

        // 1. Attendance Rate
        $totalSessions = StudentAttendance::whereHas('attendance', function ($query) {
            $query->where('batch_id', $this->batch->id);
        })->where('enrollee_id', $this->id)->count();

        $attendedSessions = StudentAttendance::whereHas('attendance', function ($query) {
            $query->where('batch_id', $this->batch->id);
        })->where('enrollee_id', $this->id)
        ->sum(DB::raw("CASE WHEN status = 'present' THEN 1 WHEN status = 'late' THEN 0.5 ELSE 0 END"));

        $attendanceRate = $totalSessions > 0 ? ($attendedSessions / $totalSessions) * 100 : 0;

        // 2. Average Grade
        $averageScore = $this->grades()->avg('grade');

        // 3. Combine Attendance and Grade into Overall Rating
        $attendanceWeight = 0.5; // 50%
        $gradeWeight = 0.5;      // 50%

        // Calculate weighted average
        $overallRating = ($attendanceRate * $attendanceWeight) +
                        ($averageScore * $gradeWeight);

        return round($overallRating, 2); // Round to two decimal places
    }

    public function is_paid()
    {
        $balance = Payment::where('enrollee_id', $this->id)->pluck('balance')->first();
        return $balance <= 0;
    }





}
