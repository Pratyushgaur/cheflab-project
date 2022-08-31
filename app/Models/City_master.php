<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;



class City_master extends Model
{
    use HasFactory, SoftDeletes;
    protected $table ='city';	
    public $timestamps = false;
}
