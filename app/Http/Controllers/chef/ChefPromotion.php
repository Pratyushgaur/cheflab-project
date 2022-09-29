<?php

namespace App\Http\Controllers\vendor\restaurant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use App\Models\VendorMenus;
use App\Models\Product_master;
use App\Models\Coupon;
use App\Models\Order_time;
use DataTables;
use Config;
use Auth;

class ChefPromotion extends Controller
{
    public function index()
    {
        return view('vendor.chef.coupon.list');
    }
}