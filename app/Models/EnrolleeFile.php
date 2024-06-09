<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnrolleeFile extends Model
{
    use HasFactory;

    protected $fillable = ['enrollee_id', 'credential_type', 'folder', 'filename', 'file_type'];

    public function enrollee()
    {
        return $this->belongsTo(Enrollee::class, 'enrollee_id');
    }
}
