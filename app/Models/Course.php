<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'code', 'name', 'training_hours', 'description', 'structure', 'course_category_id', 'folder', 'filename', 'available'
    ];

    public function enrollees()
    {
        return $this->hasMany(Enrollee::class);
    }

    public function batches()
    {
        return $this->hasMany(Batch::class);
    }
}
