<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempFile extends Model
{
    use HasFactory;
    protected $fillable = [
        'batch_id',
        'folder',
        'filename',
        'file_type',
    ];

    public function batch()
    {
        return $this->belongsTo(Batch::class);
    }

}
