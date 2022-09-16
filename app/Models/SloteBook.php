<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class SloteBook extends Model
{
    use HasFactory;
    protected $table ='slotbooking_table';	
    public $timestamps = false;
}

