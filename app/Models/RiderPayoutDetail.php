<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiderPayoutDetail extends Model
{
    use HasFactory;
    public $fillable = ['rider_id', 'amount' ,'bank_utr'];
}
