<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Deliver_boy extends Model
{
    use HasFactory,Notifiable ,HasApiTokens;

    protected $table ='deliver_boy';
    public $timestamps = false;
}
