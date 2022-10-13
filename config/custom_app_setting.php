<?php

return [

    /*
     * get config('custom_app_setting.near_by_distance')
    */

    //radius that should be cover by a restaurant
    'near_by_distance' => 20,//in miles


    //-----------------Promotion Settings---------------------------
    //slot booking
    'promotion_date_frame'=>['1'=>"One Week",'2'=>"Two Week",'3'=>"One Month"],
    'promotion_date_frame_add_days'=>['1'=>7,'2'=>14,'3'=>30],//this array keys map with "promotion_time_frame" and value : number of days we need to add for promotion_time_frame


    //Promotion time setting
    "promotion_restaurant_time"=>["7:00:00-14:00:00"=>"7 AM - 2 PM",
                                  "14:00:00-21:00:00"=>"2 PM - 9 PM",
                                  "21:00:00-4:00:00"=>"9 PM - 4 AM"//if time frame cover 2 days then make sure "to time" should be more then 24
        ],

    //number of banner slides shows
    'promotion_banner_number_of_slides'=>3,


];