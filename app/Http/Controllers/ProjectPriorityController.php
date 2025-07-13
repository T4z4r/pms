<?php

namespace App\Http\Controllers;

use App\Models\ProjectPriority;
use Illuminate\Http\Request;

class ProjectPriorityController extends Controller
{
    public function index()
    {
        $priorities = ProjectPriority::all();
        return view('project_priorities.index', compact('priorities'));
    }

    public function create()
    {
        return view('project_priorities.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'level' => 'required|integer',
            'status' => 'required|in:active,inactive',
        ]);
        ProjectPriority::create($request->all());
        return redirect()->route('project_priorities.index')->with('success', 'Priority created.');
    }

    public function edit(ProjectPriority $projectPriority)
    {
        return view('project_priorities.edit', compact('projectPriority'));
    }

    public function update(Request $request, ProjectPriority $projectPriority)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'level' => 'required|integer',
            'status' => 'required|in:active,inactive',
        ]);
        $projectPriority->update($request->all());
        return redirect()->route('project_priorities.index')->with('success', 'Priority updated.');
    }

    public function destroy(ProjectPriority $projectPriority)
    {
        $projectPriority->delete();
        return redirect()->route('project_priorities.index')->with('success', 'Priority deleted.');
    }
}
