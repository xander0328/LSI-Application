<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseDefault extends Model
{
    use HasFactory;
    protected $fillable = ['purpose', 'filename'];
}
