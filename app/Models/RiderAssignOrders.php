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
        'earning',
        'distance',
        'action'
    ];

    public function deliver_boy()
    {
        return $this->belongsTo(Deliver_boy::class,'rider_id','id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class,'order_id','id');
    }
}
