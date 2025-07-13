<?php

namespace App\Http\Controllers;

use App\Models\ProjectRole;
use Illuminate\Http\Request;

class ProjectRoleController extends Controller
{
    public function index()
    {
        $roles = ProjectRole::all();
        return view('project_roles.index', compact('roles'));
    }

    public function create()
    {
        return view('project_roles.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|in:active,inactive',
        ]);
        ProjectRole::create($request->all());
        return redirect()->route('project_roles.index')->with('success', 'Role created.');
    }

    public function edit(ProjectRole $projectRole)
    {
        return view('project_roles.edit', compact('projectRole'));
    }

    public function update(Request $request, ProjectRole $projectRole)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|in:active,inactive',
        ]);
        $projectRole->update($request->all());
        return redirect()->route('project_roles.index')->with('success', 'Role updated.');
    }

    public function destroy(ProjectRole $projectRole)
    {
        $projectRole->delete();
        return redirect()->route('project_roles.index')->with('success', 'Role deleted.');
    }
}
