<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiderOrderStatement extends Model
{
    use HasFactory;
    public $fillable = ['rider_id','paid_amount', 'pay_status','total_pay_amount', 'start_date','end_date','bank_utr_number','payment_success_date'];
}
