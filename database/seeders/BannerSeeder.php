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
                    'name'        => 'Banner 1',
                    'bannerImage' => 'banner1.jpg',
                    'position'    => '1',
                    'is_active'   => '1',
                    'price'       => '1000',

                ],
                [
                    'name'        => 'Banner 2',
                    'bannerImage' => 'banner2.jpg',
                    'position'    => '2',
                    'is_active'   => '1',
                    'price'       => '900',

                ],
                [
                    'name'        => 'Banner 3',
                    'bannerImage' => 'banner3.jpg',
                    'position'    => '3',
                    'is_active'   => '1',
                    'price'       => '800',
      
                ],
                [
                    'name'        => 'Banner 4',
                    'bannerImage' => 'banner4.jpg',
                    'position'    => '4',
                    'is_active'   => '1',
                    'price'       => '700',
             
                ],
                [
                    'name'        => 'Banner 5',
                    'bannerImage' => 'banner5.jpg',
                    'position'    => '5',
                    'is_active'   => '1',
                    'price'       => '600',

                ],
                [
                    'name'        => 'Banner 6',
                    'bannerImage' => 'banner1.jpg',
                    'position'    => '6',
                    'is_active'   => '1',
                    'price'       => '500',
                ],
                [
                    'name'        => 'Banner 7',
                    'bannerImage' => 'banner2.jpg',
                    'position'    => '7',
                    'is_active'   => '1',
                    'price'       => '400',
                ],
                [
                    'name'        => 'Banner 8',
                    'bannerImage' => 'banner3.jpg',
                    'position'    => '8',
                    'is_active'   => '1',
                    'price'       => '300',
                ],
                [
                    'name'        => 'Banner 9',
                    'bannerImage' => 'banner4.jpg',
                    'position'    => '9',
                    'is_active'   => '1',
                    'price'       => '200',
                ],
                [
                    'name'        => 'Banner 10',
                    'bannerImage' => 'banner5.jpg',
                    'position'    => '10',
                    'is_active'   => '1',
                    'price'       => '100',
                ],
            ]
        );
    }
}
