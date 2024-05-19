<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TurnInFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'turn_in_id',
        'folder',
        'filename',
        'file_type',
    ];

    // Define relationships
    public function turnIn()
    {
        return $this->belongsTo(TurnIn::class);
    }
}
