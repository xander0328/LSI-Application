<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignmentFile extends Model
{
    protected $fillable = [
        'assignment_id',
        'path',
        'file_type',
    ];

    public function assignment()
    {
        return $this->belongsTo(Assignment::class);
    }
}
