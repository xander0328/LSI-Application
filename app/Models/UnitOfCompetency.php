<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnitOfCompetency extends Model
{
    use HasFactory;

    protected $fillable = ['batch_id', 'title'];

    public function batch()
    {
        return $this->belongsTo(Batch::class);
    }

    public function lesson(){
        return $this->hasMany(Lesson::class);
    }
}
