<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryBoyTokens extends Model
{
    use HasFactory;
    protected $fillable=['rider_id','token'];
}
