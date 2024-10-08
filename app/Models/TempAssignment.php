<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempAssignment extends Model
{
    protected $table = 'temp_assignments';
    protected $fillable = [
        'batch_id',
        'folder',
        'filename',
        'file_type',
    ];
}
