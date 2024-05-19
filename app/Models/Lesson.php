<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use HasFactory;

    protected $fillable = ['batch_id', 'title'];

    public function batch()
    {
        return $this->belongsTo(Batch::class);
    }

    public function assignment()
    {
        return $this->hasMany(Assignment::class);
    }
}
