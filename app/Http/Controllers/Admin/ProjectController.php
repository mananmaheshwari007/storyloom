<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    /**
     * Display a listing of projects.
     */
    public function index()
    {
        $projects = Project::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new project.
     */
    public function create()
    {
        return view('admin.projects.create');
    }

    /**
     * Store a newly created project.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|unique:projects,slug|max:255',
            'category' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'client_name' => 'nullable|string|max:255',
            'project_url' => 'nullable|string|max:255',
            'completion_date' => 'nullable|date',
            'technologies_used' => 'nullable|string|max:255',
            'featured' => 'nullable|boolean',
            'status' => 'required|in:draft,published',
            'image_files.*' => 'nullable|image|max:3072'
        ]);

        $data = $request->except('image_files');
        $data['featured'] = $request->has('featured');

        $images = [];
        if ($request->hasFile('image_files')) {
            foreach ($request->file('image_files') as $file) {
                $path = $file->store('projects', 'public');
                $images[] = 'storage/' . $path;
            }
        }
        $data['images'] = $images;

        Project::create($data);

        return redirect()->route('admin.projects.index')->with('success', 'Project created successfully.');
    }

    /**
     * Show the form for editing the specified project.
     */
    public function edit(Project $project)
    {
        return view('admin.projects.edit', compact('project'));
    }

    /**
     * Update the specified project in storage.
     */
    public function update(Request $request, Project $project)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:projects,slug,' . $project->id,
            'category' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'client_name' => 'nullable|string|max:255',
            'project_url' => 'nullable|string|max:255',
            'completion_date' => 'nullable|date',
            'technologies_used' => 'nullable|string|max:255',
            'featured' => 'nullable|boolean',
            'status' => 'required|in:draft,published',
            'image_files.*' => 'nullable|image|max:3072'
        ]);

        $data = $request->except('image_files');
        $data['featured'] = $request->has('featured');

        $images = $project->images ?: [];
        if ($request->hasFile('image_files')) {
            foreach ($request->file('image_files') as $file) {
                $path = $file->store('projects', 'public');
                $images[] = 'storage/' . $path;
            }
        }
        
        // Remove deleted images from request
        if ($request->has('remove_images')) {
            foreach ($request->input('remove_images') as $removedIdx) {
                if (isset($images[$removedIdx])) {
                    $img = $images[$removedIdx];
                    if (str_starts_with($img, 'storage/')) {
                        Storage::disk('public')->delete(str_replace('storage/', '', $img));
                    }
                    unset($images[$removedIdx]);
                }
            }
            $images = array_values($images);
        }

        $data['images'] = $images;

        $project->update($data);

        return redirect()->route('admin.projects.index')->with('success', 'Project updated successfully.');
    }

    /**
     * Remove the specified project from storage.
     */
    public function destroy(Project $project)
    {
        if ($project->images) {
            foreach ($project->images as $img) {
                if (str_starts_with($img, 'storage/')) {
                    Storage::disk('public')->delete(str_replace('storage/', '', $img));
                }
            }
        }
        $project->delete();
        return redirect()->route('admin.projects.index')->with('success', 'Project deleted successfully.');
    }
}
