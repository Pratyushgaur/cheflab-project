<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Catogory_master extends Model
{
    use HasFactory;
    protected $table ='categories';	
    public $timestamps = false;
}
