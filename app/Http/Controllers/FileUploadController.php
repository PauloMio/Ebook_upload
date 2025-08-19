<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileUploadController extends Controller
{
    public function upload(Request $request)
    {
        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('ebooks', 'public');
            return response()->json(['path' => $path]);
        }

        return response()->json(['error' => 'No file uploaded'], 400);
    }
}
