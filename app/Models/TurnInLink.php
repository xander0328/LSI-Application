<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TurnInLink extends Model
{
    use HasFactory;

    protected $fillable = [
        'turn_in_id', 'link'
    ];

    public function turn_in(){
        return $this->belongsTo(TurnIn::class);
    }

}
