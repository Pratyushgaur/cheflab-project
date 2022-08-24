<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\facades\DB;
use Illuminate\Support\str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class Superadmin extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Request $request)
    {
       	DB::table('superadmin')->insert([
        	'name'=>'Super Admin',
        	'email'=>'admin@gmail.com',
        	'mobile_number'=>'1234567890',
        	'password'=>Hash::make('admin@123'),
			'created_at'=> date('Y-m-d h:i:s')

        ]);
    }
}
