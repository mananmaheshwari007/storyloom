<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TeamMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TeamMemberController extends Controller
{
    /**
     * Display a listing of team members.
     */
    public function index()
    {
        $members = TeamMember::orderBy('created_at', 'desc')->paginate(10);
        $team = $members;
        return view('admin.team.index', compact('members', 'team'));
    }

    /**
     * Show the form for creating a new team member.
     */
    public function create()
    {
        return view('admin.team.create');
    }

    /**
     * Store a newly created team member.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'designation' => 'required|string|max:255',
            'photo_file' => 'nullable|image|max:2048',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
            'social_links' => 'nullable|array',
            'social_links.*' => 'nullable|string'
        ]);

        $data = $request->except(['photo_file', 'social_links']);
        
        // Clean array values
        $data['social_links'] = array_filter($request->input('social_links', []));

        if ($request->hasFile('photo_file')) {
            $path = $request->file('photo_file')->store('team', 'public');
            $data['photo'] = 'storage/' . $path;
        }

        TeamMember::create($data);

        return redirect()->route('admin.team.index')->with('success', 'Team member created successfully.');
    }

    /**
     * Show the form for editing the specified team member.
     */
    public function edit(TeamMember $team)
    {
        return view('admin.team.edit', compact('team'));
    }

    /**
     * Update the specified team member in storage.
     */
    public function update(Request $request, TeamMember $team)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'designation' => 'required|string|max:255',
            'photo_file' => 'nullable|image|max:2048',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
            'social_links' => 'nullable|array',
            'social_links.*' => 'nullable|string'
        ]);

        $data = $request->except(['photo_file', 'social_links']);
        
        $data['social_links'] = array_filter($request->input('social_links', []));

        if ($request->hasFile('photo_file')) {
            if ($team->photo && str_starts_with($team->photo, 'storage/')) {
                Storage::disk('public')->delete(str_replace('storage/', '', $team->photo));
            }
            $path = $request->file('photo_file')->store('team', 'public');
            $data['photo'] = 'storage/' . $path;
        }

        $team->update($data);

        return redirect()->route('admin.team.index')->with('success', 'Team member updated successfully.');
    }

    /**
     * Remove the specified team member from storage.
     */
    public function destroy(TeamMember $team)
    {
        if ($team->photo && str_starts_with($team->photo, 'storage/')) {
            Storage::disk('public')->delete(str_replace('storage/', '', $team->photo));
        }

        $team->delete();

        return redirect()->route('admin.team.index')->with('success', 'Team member deleted successfully.');
    }
}
