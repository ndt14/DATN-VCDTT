<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class TourAdminController extends Controller
{

    public function index(){
        // fetching data from the api with 5 random breeds
        $tours = Http::get('http://be-vcdtt.datn-vcdtt.test/api/admin/tour')['message'];
        return view('admin.tour.list',compact('tours'));
    }

}
