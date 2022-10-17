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
                    'name'        => 'Banner Restaurant 1',
                    'bannerImage' => 'banner1.jpg',
                    'position'    => '1',
                    'is_active'   => '1',
                    'price'       => '1000',
                    'banner_for'  => 'restaurant',

                ],
                [
                    'name'        => 'Banner Restaurant 2',
                    'bannerImage' => 'banner2.jpg',
                    'position'    => '2',
                    'is_active'   => '1',
                    'price'       => '900',
                    'banner_for'  => 'restaurant',
                ],
                [
                    'name'        => 'Banner Restaurant 3',
                    'bannerImage' => 'banner3.jpg',
                    'position'    => '3',
                    'is_active'   => '1',
                    'price'       => '800',
                    'banner_for'  => 'restaurant',

                ],
                [
                    'name'        => 'Banner chef 1',
                    'bannerImage' => 'banner4.jpg',
                    'position'    => '1',
                    'is_active'   => '1',
                    'price'       => '700',
                    'banner_for'  => 'chef',

                ],
                [
                    'name'        => 'Banner chef 2',
                    'bannerImage' => 'banner5.jpg',
                    'position'    => '2',
                    'is_active'   => '1',
                    'price'       => '600',
                    'banner_for'  => 'chef',
                ],
                [
                    'name'        => 'Banner chef 3',
                    'bannerImage' => 'banner1.jpg',
                    'position'    => '3',
                    'is_active'   => '1',
                    'price'       => '500',
                    'banner_for'  => 'chef',
                ],
                [
                    'name'        => 'Banner dine-out 1',
                    'bannerImage' => 'banner2.jpg',
                    'position'    => '1',
                    'is_active'   => '1',
                    'price'       => '400',
                    'banner_for'  => 'dineout',
                ],
                [
                    'name'        => 'Banner dine-out 2',
                    'bannerImage' => 'banner3.jpg',
                    'position'    => '2',
                    'is_active'   => '1',
                    'price'       => '300',
                    'banner_for'  => 'dineout',
                ],
                [
                    'name'        => 'Banner dine-out 3',
                    'bannerImage' => 'banner4.jpg',
                    'position'    => '3',
                    'is_active'   => '1',
                    'price'       => '200',
                    'banner_for'  => 'dineout',
                ]
            ]
        );
    }
}
