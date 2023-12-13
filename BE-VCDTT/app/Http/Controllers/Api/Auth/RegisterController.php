<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function register(Request $request)

    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'phone_number' => 'required',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Error, please check your input!', 'status' => 404]);
        }
        $input = $request->all();
        if (User::where('email', $input['email'])->exists()) {
            return response()->json(['message' => 'Email đã được sử dụng', 'status' => 400]);
        }
        $input['password'] = bcrypt($input['password']);
        $input['status'] = 1;
        $user = User::create($input);
        $success['token'] =  $user->createToken('MyApp')->plainTextToken;
        $success['name'] =  $user->name;
        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json(['user' => $user, 'token' => $token, 'message' => 'Đăng kí thành công', 'status' => 200]);
    }
}
