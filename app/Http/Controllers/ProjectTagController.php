<?php

namespace App\Http\Controllers;

use App\Models\ProjectTag;
use Illuminate\Http\Request;

class ProjectTagController extends Controller
{
    public function index()
    {
        $tags = ProjectTag::all();
        return view('project_tags.index', compact('tags'));
    }

    public function create()
    {
        return view('project_tags.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|in:active,inactive',
        ]);
        ProjectTag::create($request->all());
        return redirect()->route('project_tags.index')->with('success', 'Tag created.');
    }

    public function edit(ProjectTag $projectTag)
    {
        return view('project_tags.edit', compact('projectTag'));
    }

    public function update(Request $request, ProjectTag $projectTag)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|in:active,inactive',
        ]);
        $projectTag->update($request->all());
        return redirect()->route('project_tags.index')->with('success', 'Tag updated.');
    }

    public function destroy(ProjectTag $projectTag)
    {
        $projectTag->delete();
        return redirect()->route('project_tags.index')->with('success', 'Tag deleted.');
    }
}
