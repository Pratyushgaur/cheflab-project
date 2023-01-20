<?php

namespace App\Http\Controllers;

use App\Models\Deliver_boy;

class DriverMapController extends Controller
{
    public function index()
    {
        return view('admin.drivers.map');
    }

    public function getDriver(Deliver_boy $driver)
    {
        return $driver;
    }
}
