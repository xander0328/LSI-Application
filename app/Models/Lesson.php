<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lesson extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['unit_of_competency_id', 'title'];

    // public function batch()
    // {
    //     return $this->belongsTo(Batch::class);
    // }

    public function unit_of_competency()
    {
        return $this->belongsTo(UnitOfCompetency::class);
    }

    public function assignment()
    {
        return $this->hasMany(Assignment::class);
    }
}
