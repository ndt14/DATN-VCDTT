<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AllocationController extends Controller
{
    //
    public function allocationManagementList() {
        return view('admin.decentralization.allocations.list');
    }
}
