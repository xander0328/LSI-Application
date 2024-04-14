<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnrolleeFiles extends Model
{
    use HasFactory;

    protected $table = 'enrollee_files';
    protected $fillable = ['enrollee_id', 'valid_id', 'diploma_tor', 'birth_certificate', 'id_picture'];

    public function enrollee()
    {
        return $this->belongsTo(Enrollee::class, 'enrollee_id');
    }
}
