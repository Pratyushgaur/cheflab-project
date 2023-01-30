<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdminMasters extends Model
{
    use HasFactory;
    protected $table = 'admin_masters';
    protected $guarded = [];
    public $timestamps = false;
}
