<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['batch_id', 'description'];
    
    public function batch()
    {
        return $this->belongsTo(Batch::class);
    }

    public function files()
    {
        return $this->hasMany(Files::class);
    }

    public function comments(){
        return $this->hasMany(Comment::class);
    }
}
