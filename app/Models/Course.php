<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'code', 'training_hours', 'description', 'category'
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
