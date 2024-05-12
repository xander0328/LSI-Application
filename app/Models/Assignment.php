<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    protected $fillable = [
        'batch_id',
        'title',
        'description',
        'due_date',
        'due_hour',
        'closing',
    ];

    protected $casts = [
        'closing' => 'boolean',
    ];

    public function batch()
    {
        return $this->belongsTo(Batch::class);
    }

    public function assignment_files()
    {
        return $this->hasMany(AssignmentFile::class);
    }
}
