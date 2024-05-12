<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'course_id', 
    ];

    public function enrollee()
    {
        return $this->hasMany(Enrollee::class);
    }

    public function post()
    {
        return $this->hasMany(Post::class);
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
        return $this->belongsTo(User::class, 'instructor_id');
    }

}
