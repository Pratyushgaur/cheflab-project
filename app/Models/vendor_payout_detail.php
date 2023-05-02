<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor_payout_detail extends Model
{
    use HasFactory;
    public $fillable = ['vendor_id', 'amount' ,'bank_utr','vendor_order_statements'];
}
