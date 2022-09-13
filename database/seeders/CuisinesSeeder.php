<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CuisinesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('cuisines')->insert(
            [
                [
                'name'=>'South Indian',
                'cuisinesImage'=>'cuisines-1.jpg',
                'position'=>'1',
                'is_active'=>'1'
                ],
                [
                'name'=>'Chinese',
                'cuisinesImage'=>'cuisines-2.jpg',
                'position'=>'2',
                'is_active'=>'1'
                ],
                [
                'name'=>'Marathi',
                'cuisinesImage'=>'cuisines-3.jpg',
                'position'=>'3',
                'is_active'=>'1'
                ],
                [
                'name'=>'Punjabi',
                'cuisinesImage'=>'cuisines-4.jpg',
                'position'=>'3',
                'is_active'=>'1'
                ]
            ]
            
        
        );
    }
}
