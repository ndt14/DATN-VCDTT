<?php
function upLoadFile($type, $file)
{
    $fileName = $type . time() . '_' . $file->getClientOriginalName();
    $filePath = url('') . '/uploads/' . $fileName;

    $file->move(public_path('uploads'), $fileName);

    return $filePath;
}

function deleteOldFile($filePath)
{
    if ($filePath != "") {
        $parsedUrl = parse_url($filePath);
        $path = ltrim($parsedUrl['path'], '/');

        $fullPath = public_path($path);
        if (file_exists($fullPath)) {
            unlink($fullPath);
        } else {
        }
    }
}
