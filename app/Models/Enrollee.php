<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enrollee extends Model
{
    use HasFactory;

    protected $dates = ['birth_date','preferred_start', 'preferred_finish'];

    protected $fillable = [
        'user_id', 
        'course_id', 'batch_id', 'completed_at', 'id_picture', 'street', 'created_at', 'updated_at', 'barangay', 'district', 'city', 'province', 'region', 'zip', 'box_no', 'sex', 'civil_status', 'telephone', 'cellular', 'email', 'employment_type', 'employment_status', 'birth_date', 'birth_place', 'citizenship', 'religion', 'height', 'weight', 'blood_type', 'sss', 'gsis', 'tin', 'disting_marks', 'preferred_schedule', 'preferred_start', 'preferred_finish'
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
}
