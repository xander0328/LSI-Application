<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TurnIn extends Model
{
    protected $fillable = [
        'enrollee_id', 'assignment_id', 'turned_in', 'turned_in_date'
    ];
    
    public function assignment()
    {
        return $this->belongsTo(Assignment::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function enrollee(){
        return $this->belongsTo(Enrollee::class);
    }

    public function turn_in_files(){
        return $this->hasMany(TurnInFile::class);
    }
    
    public function turn_in_links(){
        return $this->hasMany(TurnInLink::class);
    }
}
