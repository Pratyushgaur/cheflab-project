<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pushNotification extends Model
{
    use HasFactory;
    protected $fillable=['title', 'zone', 'send_to', 'notification_banner', 'description', 'status'];
}
