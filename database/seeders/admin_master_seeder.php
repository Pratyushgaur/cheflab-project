<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class admin_master_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('cheflab_banner_image')->insert(['id'=>1,
                                                    'delivery_charges_fix'=>"",
                                                    'delivery_charges_per_km'=>"10",
                                                    'max_preparation_time'=>"120",
                                                    'max_cod_amount'=>"500",
            "dine_out_reject_reason"=>"all table are occupied"]);

    }
}
