<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class RoleController extends Controller
{
    //

    public function __construct()
    {
        
    }

    public function roleManagementList() {
        return view('admin.decentralization.roles.list');
    }

    public function roleManagementAdd(Request $request) {
        
        return view('admin.decentralization.roles.add');
    }
    public function roleManagementEdit(Request $request) {
        
        return view('admin.decentralization.roles.edit');
    }

    // public function 
}
