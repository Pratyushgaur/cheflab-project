<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AdminMasterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('admin_masters')->insert(
            [
                [
                'privacy_policy'=>'Banner 1',
                'terms_conditions_vendor'=>'Banner 1',
                'terms_conditions_cheflab'=>'Banner 1',
                'terms_conditions_deliverboy'=>'Banner 1',
                'refund_cancellation_cheflab'=>'1',
                'aboutus'=>'1',
                'delivery_charges_fix'=>'30',
                'delivery_charges_per_km'=>'2',
                'company_name'=>'Cheflab',
                'logo'=>'Cheflab',
                'favicon'=>'Cheflab',
                'goofle_map_key'=>'Cheflab',
                'razorpay_publish_key'=>'test1',
                ],

                
            ]
            
        
        );
    }
}
