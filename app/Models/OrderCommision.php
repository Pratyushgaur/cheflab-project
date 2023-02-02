<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderCommision extends Model
{
    use HasFactory;
     protected $fillable=['is_approve','is_cancel','vendor_id', 'order_id','net_amount','vendor_commision','admin_commision', 'gross_revenue','additions','deductions','net_receivables','addition_tax','convenience_tax','admin_tax','tax','order_date','convenience_amount','tax_amount','admin_amount','cancel_by_vendor','vendor_cancel_charge'];
}

