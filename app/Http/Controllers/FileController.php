<?php

namespace App\Http\Controllers;

use App\Http\Resources\FileCollection;
use App\Http\Requests\FileRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Traits\FileStorage;
use Illuminate\Support\Str;
use App\Models\File;

class FileController extends Controller
{
    use FileStorage;

    public function index(Request $request)
    {
        return new FileCollection(File::latest()->paginate(20));
    }

    public function store(FileRequest $request)
    {
        $files = $request->file('files');
        
        foreach ($files as $file) {
            $fileName = Str::uuid()->toString() .'.'. $file->extension();

            if ($this->uploadFile($file, $fileName, 'files')) {
                File::create([
                    'name' => $fileName,
                ]);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'OK',
        ], 201);
    }

    public function getFile($id)
    {
        $file = File::findOrFail($id);

        return $this->downloadStorage($file->name, 'files');
    }

    public function softDelete($id)
    {
        $file = File::findOrFail($id);
        $file->update([
            'status' => false,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'OK',
        ], 204);
    }

    public function destroy($id)
    {
        $file = File::findOrFail($id);

        $this->deleteFile($file->name, 'files') && $file->delete();

        return response()->json([
            'success' => true,
            'message' => 'OK',
        ], 204);
    }
}
