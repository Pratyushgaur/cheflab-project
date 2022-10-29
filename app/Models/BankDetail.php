<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankDetail extends Model
{
    use HasFactory;
     protected $fillable=['vendor_id', 'holder_name', 'account_no', 'ifsc', 'bank_name', 'cancel_check'];
}
