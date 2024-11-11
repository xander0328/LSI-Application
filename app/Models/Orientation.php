<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Orientation extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['date_time', 'batch_id'];

    public function batch(){
        return $this->belongsTo(Batch::class);
    }
}
