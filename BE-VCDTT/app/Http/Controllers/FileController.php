<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class FileController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'files' => 'required',
        ]);
        $fileTypes = ['jpg', 'jpeg', 'png'];
        $fileNames = [];
        foreach ($request->file('files') as $file) {
            $extension = $file->getClientOriginalExtension();
            if (!in_array($extension, $fileTypes)) {
                return response()->json(['message' => 'Invalid file type','status' => 500 ]);
            }

            $fileName = time().'.'.$file->extension();  
            $file->move(public_path('uploads'), $fileName);
            $fileNames[] = $fileName;
        }
    
        return response()->json(['message' => 'Upload file success','files' => $fileName, 'status' => 200]);
    }
}
