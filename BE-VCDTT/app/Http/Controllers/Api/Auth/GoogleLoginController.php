<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;

class GoogleLoginController extends Controller
{
    //
    public function redirectToGoogle()
    {
        return response()->json([
            'url' => Socialite::driver('google')->stateless()->redirect()->getTargetUrl()
        ]);
    }

    public function handleGoogleCallback()
    {
        $googleUser = Socialite::driver('google')->stateless()->user();
        $user = User::where('email', '=', $googleUser->email)->first();
        if ($user) {
            if ($user->google_id == null) {
                User::where('email', '=', $googleUser->email)->update(
                    [
                        'google_id' => $googleUser->id
                    ]
                );
                $token = $user->createToken('api-token')->plainTextToken;
                return response()->json([
                    'user' => $user,
                    'token' => $token
                ]);
            }
            $token = $user->createToken('api-token')->plainTextToken;
            return response()->json([
                'user' => $user,
                'token' => $token
            ]);
        } elseif (!$user) {
            $user = User::create([
                'name' => $googleUser->name,
                'email' => $googleUser->email,
                'status' => 1,
                'google_id' => $googleUser->id
            ]);
            $token = $user->createToken('api-token')->plainTextToken;
            return response()->json([
                'user' => $user,
                'token' => $token
            ]);
        }
        return response()->json(['message' => 'Logged in failed'], 401);
    }
}
