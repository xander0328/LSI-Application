<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Enrollee extends Model
{
    use HasFactory, SoftDeletes;

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

    public function assignment(){
        return $this->hasMany(Assignment::class);
    }

    public function enrollee_attendances(){
        return $this->hasMany(StudentAttendance::class);
    }
}
