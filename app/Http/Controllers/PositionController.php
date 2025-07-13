<?php

namespace App\Http\Controllers;

use App\Models\Position;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PositionController extends Controller
{
    public function index()
    {
        $positions = Position::latest()->get();
        return view('positions.index', compact('positions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:positions,name',
            'status' => 'required|in:active,inactive',
        ]);

        Position::create([
            'name' => $request->name,
            'status' => $request->status,
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('positions.index')->with('success', 'Position created successfully.');
    }

    public function update(Request $request, $id)
    {
        $position = Position::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255|unique:positions,name,' . $position->id,
            'status' => 'required|in:active,inactive',
        ]);

        $position->update([
            'name' => $request->name,
            'status' => $request->status,
        ]);

        return redirect()->route('positions.index')->with('success', 'Position updated successfully.');
    }

    public function destroy($id)
    {
        $position = Position::findOrFail($id);
        $position->delete();

        return redirect()->route('positions.index')->with('success', 'Position deleted successfully.');
    }
}
