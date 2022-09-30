<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TableServiceBooking extends Model
{
    use HasFactory;

    public $timestamps = true;

    protected $fillable=['vendor_id','user_id','booked_no_guest','booked_slot_time_from','booked_slot_time_to','booked_slot_discount'];
}
