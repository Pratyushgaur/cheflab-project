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
        \DB::table('cheflab_banner_image')->insert(
            [
                [
                'name'=>'Banner 1',
                'bannerImage'=>'banner1.jpg',
                'position'=>'1',
                'is_active'=>'1'
                ],
                [
                'name'=>'Banner 2',
                'bannerImage'=>'banner2.jpg',
                'position'=>'1',
                'is_active'=>'1'
                ],
                [
                'name'=>'Banner 3',
                'bannerImage'=>'banner3.jpg',
                'position'=>'1',
                'is_active'=>'1'
                ],
                [
                    'name'=>'Banner 4',
                    'bannerImage'=>'banner4.jpg',
                    'position'=>'1',
                    'is_active'=>'1'
                ],
                [
                    'name'=>'Banner 5',
                    'bannerImage'=>'banner5.jpg',
                    'position'=>'1',
                    'is_active'=>'1'
                ],
                [
                    'name'=>'Banner 6',
                    'bannerImage'=>'banner1.jpg',
                    'position'=>'1',
                    'is_active'=>'1'
                    ],
                    [
                    'name'=>'Banner 7',
                    'bannerImage'=>'banner2.jpg',
                    'position'=>'1',
                    'is_active'=>'1'
                    ],
                    [
                    'name'=>'Banner 8',
                    'bannerImage'=>'banner3.jpg',
                    'position'=>'1',
                    'is_active'=>'1'
                    ],
                    [
                    'name'=>'Banner 9',
                    'bannerImage'=>'banner4.jpg',
                    'position'=>'1',
                    'is_active'=>'1'
                    ],
                    [
                    'name'=>'Banner 10',
                    'bannerImage'=>'banner5.jpg',
                    'position'=>'1',
                    'is_active'=>'1'
                    ],
            ]
            
        
        );
    }
}
