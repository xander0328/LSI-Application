<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TurnIn extends Model
{
    protected $fillable = [
        'user_id', 'assignment_id', 'turned_in', 'turned_in_date'
    ];
    
    public function assignment()
    {
        return $this->belongsTo(Assignment::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
