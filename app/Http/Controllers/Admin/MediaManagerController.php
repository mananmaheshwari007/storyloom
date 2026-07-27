<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MediaManagerController extends Controller
{
    /**
     * Display a listing of media files.
     */
    public function index()
    {
        if (!Storage::disk('public')->exists('media')) {
            Storage::disk('public')->makeDirectory('media');
        }

        $files = Storage::disk('public')->files('media');
        
        $mediaList = [];
        foreach ($files as $file) {
            $mediaList[] = [
                'name' => basename($file),
                'path' => 'storage/' . $file,
                'size' => round(Storage::disk('public')->size($file) / 1024, 2) . ' KB',
                'raw_path' => $file
            ];
        }

        return view('admin.media.index', compact('mediaList'));
    }

    /**
     * Store a newly created media file in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|image|max:5120' // 5MB Limit
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $originalName = $file->getClientOriginalName();
            
            // Generate slug filename
            $filename = pathinfo($originalName, PATHINFO_FILENAME);
            $extension = $file->getClientOriginalExtension();
            $cleanName = Str::slug($filename) . '.' . $extension;

            if (Storage::disk('public')->exists('media/' . $cleanName)) {
                $cleanName = time() . '_' . $cleanName;
            }

            $file->storeAs('media', $cleanName, 'public');

            return redirect()->route('admin.media.index')->with('success', 'Media file uploaded successfully.');
        }

        return redirect()->route('admin.media.index')->with('error', 'No file was uploaded.');
    }

    /**
     * Remove the specified media file from storage.
     */
    public function destroy(Request $request)
    {
        $request->validate([
            'path' => 'required|string'
        ]);

        $filePath = $request->input('path');

        if (Storage::disk('public')->exists($filePath)) {
            Storage::disk('public')->delete($filePath);
            return redirect()->route('admin.media.index')->with('success', 'Media file deleted successfully.');
        }

        return redirect()->route('admin.media.index')->with('error', 'File not found in storage.');
    }
}
