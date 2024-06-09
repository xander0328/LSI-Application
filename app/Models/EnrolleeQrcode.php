<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnrolleeQrcode extends Model
{
    use HasFactory;

    protected $fillable = ['enrollee_id', 'qr_code'];

}
