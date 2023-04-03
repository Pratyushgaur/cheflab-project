<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PendingOrders extends Model
{
    use HasFactory;
    protected $table ='pending_payment_orders';	
}
