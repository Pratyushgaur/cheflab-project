<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor_order_statement extends Model
{
    use HasFactory;
    public $fillable = ['vendor_id','vendor_cancel_deduction','paid_amount', 'pay_status','total_pay_amount', 'start_date','end_date','bank_utr_number','payment_success_date'];
}
