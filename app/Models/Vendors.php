<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;


class Vendors extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = ['table_service','password_change_otp','auto_accept_prepration_time'];

    public function vendor_order_time()
    {
        $this->hasMany(Order_time::class);
    }

    public function products()
    {
        return $this->hasMany(Product_master::class,'userId');
        
        
    }

    static function is_avaliavle($vendor_id)
    {
//        date_default_timezone_set(config('app.timezone'));
        $v = Vendors::find($vendor_id);
    //    dd($v);
        if (!$v->is_online)
            return ['offline'];
        return \App\Models\Order_time::where('vendor_id',$vendor_id)
            ->where('day_no',Carbon::now()->dayOfWeek)
            ->where('start_time','<=',date('H:i:s'))
            ->where('end_time','>',date('H:i:s'))
            ->exists();
    }


}
