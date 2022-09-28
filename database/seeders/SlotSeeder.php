<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class BannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('slot')->insert(
            [
                [
                'slot_name'=>'1',
                'position'=>'1',
                'price'=>'100',
                'status'=>'1'
                ],
                [
                'slot_name'=>'2',
                'position'=>'2',
                'price'=>'200',
                'status'=>'1'
                ],
                [
                'slot_name'=>'3',
                'position'=>'3',
                'price'=>'300',
                'status'=>'1'
                ],
                [
                'slot_name'=>'4',
                'position'=>'4',
                'price'=>'400',
                'status'=>'1'
                ],
                [
                'slot_name'=>'5',
                'position'=>'5',
                'price'=>'500',
                'status'=>'1'
                ],
                
            ]
            
        
        );
    }
}
