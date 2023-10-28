<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        return view('dashboard');
    }
    public function totalEarn(Request $request){
        //
        //today
        //this week
        //this month
        //this year
        //over all
        //views how many?
        //passengers how many?
        //sold how many?
    }
    public function totalEarning(Request $request){
        //
        //daily
        //weekly
        //monthly
        //yearly-not important
        //views how many?
        //passengers how many?
        //sold how many?
    }
    public function totalEarnCate(Request $request){
        // money made by category
    }
}

