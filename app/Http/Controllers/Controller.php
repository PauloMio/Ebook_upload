<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ebook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EbookController extends Controller
{
    public function index()
    {
        $ebooks = Ebook::latest()->get();
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
            Ebook::create([
                ...$ebookData,
                'coverage' => $ebookData['coverage'] ?? null,
                'pdf' => $ebookData['pdf'] ?? null,
            ]);
        }

        return redirect()->route('ebooks.index')->with('success', 'Ebooks created successfully!');
    }

    // (Update and destroy can be built the same way)
}
