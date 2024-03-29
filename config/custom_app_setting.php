<?php

return [

    /*
     * get config('custom_app_setting.near_by_distance')
    */

    //radius that should be cover by a restaurant
    'near_by_distance'                  => 20,//in KM
    'near_by_driver_distance'                  => 35, //in KM

    //-----------------Promotion Settings---------------------------
    //slot booking
    'promotion_date_frame'              => ['1' => "One Week", '2' => "Two Week", '3' => "One Month"],
    'promotion_date_frame_add_days'     => ['1' => 7, '2' => 14, '3' => 30],//this array keys map with "promotion_time_frame" and value : number of days we need to add for promotion_time_frame
    'promotion_date_frame_admin'        => [7 => "One Week", 14 => "Two Week", 30 => "One Month"],

    //Promotion time setting
    "promotion_restaurant_time"         => ["7:00:00-14:00:00"  => "7 AM - 2 PM",
                                            "14:00:00-21:00:00" => "2 PM - 9 PM",
                                            "21:00:00-4:00:00"  => "9 PM - 4 AM"
    ],

    //number of banner slides shows
    'promotion_banner_number_of_slides' => 3,
    'promotion_banner_for'              => ['chef'          => "Chef Home Slider Banner",
                                            'restaurant'    => "Restaurant Home Slider Banner",
                                            'dineout'       => "Dine-out Promotion",
                                            "order_traking" => "Order Tracking Banner"
    ],//slotbooking_table:"for" column enum values ,same "cheflab_banner_image" : banner_or column in mobile app where banner should be displed

    'promotion_banner_for_only_values'       => ['cheflab', 'chef', 'restaurant', 'dineout', 'order_traking'],//slotbooking_table:"for" column enum values ,same "cheflab_banner_image" : banner_or column in mobile app where banner should be displed


    //blog promotion "app_promotion_blog_setting" table column :"blog_promotion_date_frame"
    'blog_promotion_date_frame'              => ['1' => "One Week", '2' => "Two Week", '3' => "One Month"],
    'blog_promotion_date_frame_add_days'     => ['1' => 7, '2' => 14, '3' => 30],//this array keys map with "promotion_time_frame" and value : number of days we need to add for promotion_time_frame
    //number of banner slides shows
    'blog_promotion_banner_number_of_slides' => 3,


    'deliver_boy_type' => [1 => 'Pure Commission', 2 => "Rent Commission", 3 => "In House"],//deliver_boy table : type column

    'product_preparation_time' => [5   => "5 Minutes", 10 => "10 Minutes", 15 => "15 Minutes", 20 => "20 Minutes", 30 => "30 Minutes",
                                   45  => "45 Minutes", 60 => "60 Minutes", 75 => "1 Hour 15 Minutes", 90 => "1 Hour 30 Minutes", 105 => "1 Hour 45 Minutes",
                                   120 => "2 Hours"],//"products" table preparation_time column

    'product_chili_level' => ['no' => "Not Available", '1' => '1 Chili', '2' => '2 Chili', '3' => '3 Chili'],//deliver_boy table : type column

    'admin_master_id' => '1',//admin_master id

    'blog_type' => ['1' => 'vendor', '2' => 'product'],//table :app_promotion_blog column:blog_type

    'product_type' => ['veg' => 'Veg', 'non_veg' => "Non-veg"],//table :products column:type

    'vendor_type' => ['restaurant' => "Restaurant", 'chef' => "Chef"],//table :products column:type

    'vendor_food_type' => [1 => 'Veg', 3 => 'Veg + Non Veg'],

    "product_approve" => [1 => 'Approved', 2 => 'pending', 3 => 'Reject'],//product : table, column name :product_approve
    "product_status"  => [1 => "Active", 0 => "in-active"],//tabe: products ,column name :status

    'dine_out_slot_time' => [
        '30'  => '30 Minutes',
        '60'  => '1 Hour',
        '120' => '2 Hours',
        '180' => '3 Hours',
    ]
];
