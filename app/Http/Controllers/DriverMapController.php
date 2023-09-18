<?php

namespace App\Http\Controllers;

use App\Models\Deliver_boy;

class DriverMapController extends Controller
{
    public function index()
    {
        $driver = Deliver_boy::select('name','mobile','id')->get();
        return view('admin.drivers.map2',compact('driver'));
    }

    public function getDriver(Deliver_boy $driver)
    {
        return $driver;
    }
}
