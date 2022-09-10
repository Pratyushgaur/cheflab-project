<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('categories')->insert(
            [
                [
                'name'=>'Pizza',
                'categoryImage'=>'category-1.png',
                'position'=>'1',
                'is_active'=>'1'
                ],
                [
                'name'=>'Burger',
                'categoryImage'=>'category-2.png',
                'position'=>'2',
                'is_active'=>'1'
                ],
                [
                'name'=>'Pasta',
                'categoryImage'=>'category-3.png',
                'position'=>'3',
                'is_active'=>'1'
                ],
                [
                'name'=>'Chat',
                'categoryImage'=>'category-4.jpg',
                'position'=>'4',
                'is_active'=>'1'
                ]
            ]
            
        
        );
    
    }
}
