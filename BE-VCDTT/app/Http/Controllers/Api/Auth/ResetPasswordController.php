<?php


namespace App\Http\Controllers\Api\Auth;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Str;

use Illuminate\Http\Request;
use App\Models\PasswordReset;
use App\Http\Controllers\Controller;
use App\Notifications\ResetPasswordRequest;

class ResetPasswordController extends Controller
{
    /**
     * Create token password reset.
     *
     * @param  ResetPasswordRequest $request
     * @return JsonResponse
     */
    public function sendMail(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if ($user) {
            $passwordReset = PasswordReset::updateOrCreate([
                'email' => $user->email,
            ], [
                'token' => Str::random(60),
            ]);
            if ($passwordReset) {
                $user->notify(new ResetPasswordRequest($passwordReset->token));
            }

            return response()->json([
                'message' => 'Chúng tôi đã gửi mail đặt lại mật khẩu. Vui lòng kiểm tra email của bạn!',
                'status' => 200
            ]);
        } else {
            return response()->json([
                'message' => 'Không tìm thấy email!',
                'status' => 404
            ]);
        }
    }

    public function reset(Request $request, $token)
    {
        $passwordReset = PasswordReset::where('token', $token)->firstOrFail();
        if (Carbon::parse($passwordReset->updated_at)->addMinutes(15)->isPast()) {
            $passwordReset->delete();

            return response()->json([
                'message' => 'Token không hợp lệ.',
                'status' => 422
            ]);
        }
        $user = User::where('email', $passwordReset->email)->firstOrFail();
        $updatePasswordUser = $user->update($request->only('password'));
        $passwordReset->delete();

        if ($updatePasswordUser) {
            return response()->json([
                'message' => 'Đổi mật khẩu thành công',
                'status' => 200
            ]);
        }
    }
}
