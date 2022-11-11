<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DeliveryboySeeder extends Seeder
{
    public function run()
    {
        \DB::table('delivery_boy_setting')->insert(
            [
                [
                    'a_to_b_charge'        => '5',
                    'b_to_c_charge' => '5',
                    'fix_charge_1'    => '1',
                    'fix_charge_2'   => '1',
                    'incentive_one'       => '10',
                    'incentive_to'  => '10',

                ],
            ]
        );
    }
}