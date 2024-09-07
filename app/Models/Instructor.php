<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instructor extends Model
{
    use HasFactory;

    protected $fillable = ['user_id',
    'folder',
    'id_picture',
    'sex',
    'street',
    'barangay',
    'city',
    'province',
    'region'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function batches(){
        return $this->hasMany(Batch::class);
    }
}
