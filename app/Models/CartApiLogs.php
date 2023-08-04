<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartApiLogs extends Model
{
    use HasFactory;
    protected $fillable = ['userId','api_request_log','api_response_log'];
}
