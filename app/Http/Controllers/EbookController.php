<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Ebook;
use App\Models\Ebooks;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EbookController extends Controller
{
    public function index()
    {
        $ebooks = Ebooks::latest()->get();
        return view('admin.ebooks.index', compact('ebooks'));
    }

    public function create()
    {
        return view('admin.ebooks.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'ebooks' => 'required|array',
            'ebooks.*.title' => 'nullable|string|max:200',
            'ebooks.*.description' => 'nullable|string',
            'ebooks.*.author' => 'nullable|string|max:100',
            'ebooks.*.category' => 'nullable|string|max:100',
            'ebooks.*.edition' => 'nullable|string|max:50',
            'ebooks.*.publisher' => 'nullable|string|max:100',
            'ebooks.*.copyrightyear' => 'nullable|integer',
            'ebooks.*.location' => 'nullable|string|max:100',
            'ebooks.*.class' => 'nullable|string',
            'ebooks.*.subject' => 'nullable|string',
            'ebooks.*.doi' => 'nullable|string',
            'ebooks.*.coverage' => 'nullable|string', // Filepond returns path
            'ebooks.*.pdf' => 'nullable|string', // Filepond returns path
        ]);

        foreach ($request->ebooks as $ebookData) {
            Ebooks::create([
                ...$ebookData,
                'coverage' => $ebookData['coverage'] ?? null,
                'pdf' => $ebookData['pdf'] ?? null,
            ]);
        }

        return redirect()->route('ebooks.index')->with('success', 'Ebooks created successfully!');
    }

    public function upload(Request $request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $path = $file->store('temp', 'public'); // Store temporarily in storage/app/public/temp
            return response()->json(['path' => $path], 200);
        }
        return response()->json(['error' => 'No file uploaded'], 400);
    }
}
