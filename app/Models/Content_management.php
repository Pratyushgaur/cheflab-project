<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;



class Content_management extends Model
{
    use HasFactory, SoftDeletes;
    protected $table ='content_management';	
    public $timestamps = false;
}
