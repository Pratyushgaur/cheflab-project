<?php

    use App\Models\Orders;
    use Carbon\Carbon;
    function test(){

    return 'yes';
}


function front_end_date_time($datetime)
{
    return date('d F, Y h:i a', strtotime($datetime));
}

function mysql_date_time($datetime='')
{
    if($datetime!='')
        return date('Y-m-d H:i:s', strtotime($datetime));
    else
        return date('Y-m-d H:i:s');
}

function mysql_date($datetime)
{
    return date('Y-m-d', strtotime($datetime));
}

function mysql_time($datetime)
{
    return date('H:i:s', strtotime($datetime));
}

function mysql_date_time_marge($date,$time)
{
    $date_only=date('Y-m-d', strtotime($date));
    $time_only=date('H:i:s', strtotime($time));
    return date('Y-m-d H:i:s', strtotime($date_only.$time_only));
}

function mysql_add_time($datetime,$add_time_minites)
{
    return date('Y-m-d H:i:s', strtotime('+'.$add_time_minites.' minutes',strtotime($datetime)));
}

function get_time_ago($time)
{
    $time_difference = time() - $time;

    if ($time_difference < 1) {
        return 'less than 1 second ago';
    }
    $condition = array(12 * 30 * 24 * 60 * 60 => 'year',
        30 * 24 * 60 * 60 => 'month',
        24 * 60 * 60 => 'day',
        60 * 60 => 'hour',
        60 => 'minute',
        1 => 'second'
    );

    foreach ($condition as $secs => $str) {
        $d = $time_difference / $secs;

        if ($d >= 1) {
            $t = round($d);
            return 'about ' . $t . ' ' . $str . ($t > 1 ? 's' : '') . ' ago';
        }
    }
}

function show_time_slots($start_time, $end_time, $duration, $break)
{

    $time_slots = array();
    $start_time = strtotime($start_time);
    $end_time = strtotime($end_time);

    $add_mins = $duration * 60;

    while ($start_time <= $end_time) {
        $time_slots[] = date("Y-m-d H:i", $start_time);
        $start_time += $add_mins;
    }

    $time_slots = array_diff($time_slots, $break);

    return $time_slots;

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
