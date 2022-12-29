<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paymentsetting extends Model
{
    use HasFactory;
     protected $fillable=['id', 'additions', 'convenience_fee', 'order_rejection'];
}
