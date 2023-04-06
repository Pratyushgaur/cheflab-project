<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PendingPaymentOrders extends Model
{
    use HasFactory;
    protected $fillable=['transaction_id', 'request_data', 'payment_status', 'cancel_reason', 'order_generated', 'order_generate_error'];

}
