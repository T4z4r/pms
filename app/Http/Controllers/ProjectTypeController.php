<?php

namespace App\Http\Controllers;

use App\Models\ProjectType;
use Illuminate\Http\Request;

class ProjectTypeController extends Controller
{
    public function index()
    {
        $types = ProjectType::all();
        return view('project_types.index', compact('types'));
    }

    public function create()
    {
        return view('project_types.create');
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255']);
        ProjectType::create($request->all());
        return redirect()->route('project_types.index')->with('success', 'Project Type created.');
    }

    public function edit(ProjectType $projectType)
    {
        return view('project_types.edit', compact('projectType'));
    }

    public function update(Request $request, ProjectType $projectType)
    {
        $request->validate(['name' => 'required|string|max:255']);
        $projectType->update($request->all());
        return redirect()->route('project_types.index')->with('success', 'Project Type updated.');
    }

    public function destroy(ProjectType $projectType)
    {
        $projectType->delete();
        return redirect()->route('project_types.index')->with('success', 'Project Type deleted.');
    }
}
