<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $fillable = ['enrollee_id', 'balance'];

    public function enrollee()
    {
        return $this->belongsTo(Enrollee::class);
    }

    public function payment_logs()
    {
        return $this->hasMany(PaymentLog::class);
    }
}
