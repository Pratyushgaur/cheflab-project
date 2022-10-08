<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TableServiceDiscount extends Model
{
    use HasFactory;

    protected $fillable=['vendor_id','day_no','discount_percent'];
}
