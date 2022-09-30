<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class RootImage extends Model
{
    use HasFactory,SoftDeletes;
    protected $table ='cheflab_banner_image';	
    public $timestamps = false;
}
