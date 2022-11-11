<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class DeliveryboySetting extends Model
{
    use HasFactory,SoftDeletes;
    protected $table ='delivery_boy_setting';	
    public $timestamps = false;
}
