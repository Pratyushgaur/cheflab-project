<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TableService extends Model
{
    use HasFactory;

    protected $fillable = ['vendor_id', 'no_guest', 'slot_time', 'slot_discount'];
}
