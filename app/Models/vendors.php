<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;


class vendors extends Authenticatable
{
    use HasFactory,Notifiable;


    public function vendor_order_time(){
        $this->hasMany(Order_time::class);
    }

    public function is_avaliavle($vendor_id){
//        date_default_timezone_set(config('app.timezone'));
        $v=Vendors::find($vendor_id);
        if(!$v->is_online)
            return ['offline'];

        return \App\Models\Order_time::where('vendor_id',$vendor_id)
            ->where('day_no',Carbon::now()->dayOfWeek)
            ->where('start_time','<=',date('H:i:s'))
            ->where('end_time','>',date('H:i:s'))
            ->exists();
            // ->toSql();


    }



}
