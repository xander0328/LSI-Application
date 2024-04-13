<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Files extends Model
{
    use HasFactory;

    protected $fillable = ['post_id', 'path', 'file_type'];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
