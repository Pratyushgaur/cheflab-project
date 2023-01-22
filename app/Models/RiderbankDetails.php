<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiderbankDetails extends Model
{
    use HasFactory;
    protected $table ='riderbank_details';
     protected $fillable=['rider_id', 'holder_name', 'account_no', 'ifsc', 'bank_name', 'cancel_check'];
}
