<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiderAssignOrders extends Model
{
    use HasFactory;
    protected $fillable = [
        'rider_id',
        'order_id',
        'action'
    ];
}
