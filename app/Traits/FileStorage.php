<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;

trait FileStorage
{
    public function uploadFile($file, $fileName, $folder = 'files')
    {
        return $file->storeAs('/'. $folder, $fileName, 'public') ? true : false;
    }

    public function getStorage($fileName, $folder = 'files')
    {
        return Storage::disk('public')->get('/' . $folder . '/' . $fileName);
    }

    public function downloadStorage($fileName, $folder = 'files')
    {
        return Storage::disk('public')->download('/' . $folder . '/' . $fileName);
    }

    public function deleteFile($fileName, $folder)
    {
        return Storage::disk('public')->delete($folder .'/'. $fileName) ? true : false;
    }
}
