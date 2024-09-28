<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'code',
        'name',
        'training_hours',
        'description',
        'structure',
        'course_category_id',
        'folder',
        'filename',
        'available',
        'registration_fee',
        'bond_deposit',
        'featured'
    ];

    public function enrollees()
    {
        return $this->hasMany(Enrollee::class);
    }

    public function batches()
    {
        return $this->hasMany(Batch::class);
    }

    public function course_category(){
        return $this->belongsTo(CourseCategory::class);
    }

    public function course_id_template(){
        return $this->hasOne(CourseIdTemplate::class);
    }
}
