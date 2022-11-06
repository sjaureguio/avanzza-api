<?php

namespace App\Http\Controllers;

use App\Http\Resources\FileCollection;
use Illuminate\Http\Request;
use App\Models\File;

class FileController extends Controller
{
    public function index(Request $request)
    {
        $records = File::where('name', 'ILIKE', "%{$request->search}%")->latest();

        $data = new FileCollection($records->paginate(20));

        return response()->json([
            'success' => true,
            'message' => 'OK',
            'data' => $data
        ], 200);
    }
}
