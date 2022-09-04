<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Chef_video extends Model
{
    use HasFactory,SoftDeletes;
    protected $table ='chef_video';	
    public $timestamps = false;
}
