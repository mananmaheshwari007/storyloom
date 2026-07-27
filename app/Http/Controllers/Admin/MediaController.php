<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Media;
use App\Services\MediaService;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    public function index(Request $request)
    {
        $folder = $request->input('folder', 'uploads');
        
        $mediaFiles = Media::where('folder', $folder)
            ->latest()
            ->paginate(24);

        // Standard folder list for categorization
        $folders = Media::distinct()->pluck('folder')->toArray();
        if (empty($folders)) {
            $folders = ['uploads', 'hero', 'about', 'services', 'projects', 'portfolio', 'products', 'team', 'blog'];
        } else {
            // merge default folders to ensure availability
            $folders = array_unique(array_merge(['uploads', 'hero', 'about', 'services', 'projects', 'portfolio', 'products', 'team', 'blog'], $folders));
        }

        return view('admin.media.index', compact('mediaFiles', 'folders', 'folder'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|file|image|max:10240', // Max 10MB
            'folder' => 'required|string|max:100'
        ]);

        if ($request->hasFile('file')) {
            MediaService::uploadAndOptimize($request->file('file'), $request->folder);
            return redirect()->back()->with('success', 'File uploaded and optimized successfully.');
        }

        return redirect()->back()->with('error', 'No file was selected.');
    }

    public function destroy(Media $media)
    {
        MediaService::delete($media->filepath);
        return redirect()->back()->with('success', 'File deleted successfully.');
    }
}
