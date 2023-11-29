<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class UploadController extends Controller
{
    //
    public function upload(Request $request)
    {

        if ($request->hasFile("upload")) {
            $file = $request->file('upload'); // Lấy tệp tin từ yêu cầu tải lên

            // Di chuyển tệp tin đến thư mục public/uploads
            $filePath = public_path('ckfinder/uploads/' . $file->getClientOriginalName());
            File::move($file->path(), $filePath);

            // Trả về đường dẫn tới tệp tin sau khi được lưu
            return response()->json(['url' => asset('ckfinder/uploads/' . $file->getClientOriginalName()), 'uploaded' => 1]);
        }

    }
}
