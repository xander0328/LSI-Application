<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Batch extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $fillable = [
        'user_id', 'course_id', 'instructor_id', 'completed_at'
    ];

    public function enrollee()
    {
        return $this->hasMany(Enrollee::class);
    }

    public function post()
    {
        return $this->hasMany(Post::class);
    }

    public function temp_post_files()
    {
        return $this->hasMany(TempFile::class);
    }


    public function lesson()
    {
        return $this->hasMany(Lesson::class);
    }

    public function assignment()
    {
        return $this->hasMany(Assignment::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function instructor()
    {
        return $this->belongsTo(Instructor::class);
    }

    public function unit_of_competency(){
        return $this->hasMany(UnitOfCompetency::class);
    }

}
