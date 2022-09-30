<?php

    use App\Models\Orders;
    use Carbon\Carbon;
    function test(){

        return 'yes';
    }

    function get_time_ago( $time )
    {
        $time_difference = time() - $time;

        if( $time_difference < 1 ) { return 'less than 1 second ago'; }
        $condition = array( 12 * 30 * 24 * 60 * 60 =>  'year',
            30 * 24 * 60 * 60       =>  'month',
            24 * 60 * 60            =>  'day',
            60 * 60                 =>  'hour',
            60                      =>  'minute',
            1                       =>  'second'
        );

        foreach( $condition as $secs => $str )
        {
            $d = $time_difference / $secs;

            if( $d >= 1 )
            {
                $t = round( $d );
                return 'about ' . $t . ' ' . $str . ( $t > 1 ? 's' : '' ) . ' ago';
            }
        }
    }
    function vendorOrderCountByStatus($vendor_id,$status)
    {
        return Orders::where(['vendor_id'=>$vendor_id,'order_status'=>$status])->count();
    }
    function vendorTodayOrderCount($vendor_id)
    {
        return Orders::where(['vendor_id'=>$vendor_id])->whereDate('created_at', Carbon::today())->count();
    }
    function vendorTotalOrderCount($vendor_id)
    {
        return Orders::where(['vendor_id'=>$vendor_id])->count();
    }
?>
