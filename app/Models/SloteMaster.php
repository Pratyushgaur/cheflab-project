<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class SloteMaster extends Model
{
    use HasFactory;
    protected $table ='slot';	
    public $timestamps = false;
}

