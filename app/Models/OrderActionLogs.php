<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderActionLogs extends Model
{
    use HasFactory;
    protected $fillable = ['orderid','action','rider_id'];

}
