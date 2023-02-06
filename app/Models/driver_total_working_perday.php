<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Driver_total_working_perday extends Model
{
    use HasFactory;
    protected $fillable=['rider_id','total_hr','current_date'];
}
