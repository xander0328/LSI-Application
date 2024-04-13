<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    protected $table = 'enrollee_education';

    protected $fillable = ['enrollee_id', 'school_name', 'educational_level', 'school_year', 'degree', 'minor', 'major', 'units_earned', 'honors_received'];

}
