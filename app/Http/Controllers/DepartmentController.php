<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::latest()->get();
        return view('departments.index', compact('departments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:departments,name',
            'status' => 'required|in:active,inactive',
        ]);

        Department::create([
            'name' => $request->name,
            'status' => $request->status,
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('departments.index')->with('success', 'Department created successfully.');
    }

    public function edit($id)
    {
        $department = Department::findOrFail($id);
        return response()->json($department);
    }

    public function update(Request $request, $id)
    {
        $department = Department::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255|unique:departments,name,' . $department->id,
            'status' => 'required|in:active,inactive',
        ]);

        $department->update([
            'name' => $request->name,
            'status' => $request->status,
        ]);

        return redirect()->route('departments.index')->with('success', 'Department updated successfully.');
    }

    public function destroy($id)
    {
        $department = Department::findOrFail($id);
        $department->delete();

        return redirect()->route('departments.index')->with('success', 'Department deleted successfully.');
    }
}
