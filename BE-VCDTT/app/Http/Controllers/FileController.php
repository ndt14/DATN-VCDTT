<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class FileController extends Controller
{
    public function store(Request $request)
    {
        if ($request->hasFile('files')) {
            $images = [];
            $fileNames = [];
            $files = $request->file('files');
            $tour_id = $request->input('tour_id');

            foreach ($files as $file) {
                $type = $file->extension();
                $fileName = time() . '_' . uniqid(). '.' . $type;
                $file->move(public_path('uploads'), $fileName);
                $fileNames[] = [
                    'name' => time() . '_' . uniqid(),
                    'type' => $type,
                    'full_name'=> $fileName,
                ];
            }
            foreach ($fileNames as $img) {
                $data = [
                    'name' => $img['name'],
                    'type' => $img['type'],
                    'url' => url('').'/uploads/' . $img['full_name'],
                    'tour_id' => $tour_id
                ];
                $newImage = Image::create($data);
                $images[] = $newImage;
            }
        }

        return response()->json(['message' => 'Upload file success','files' => $fileName, 'status' => 200]);
    }
}
