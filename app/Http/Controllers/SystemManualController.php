<?php
namespace App\Http\Controllers;

use App\Models\SystemManual;
use App\Models\System;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class SystemManualController extends Controller
{
    public function index()
    {
        $manuals = SystemManual::with('system', 'creator', 'updater')
            ->whereIn('system_id', System::where('created_by', Auth::id())
                ->orWhere('assigned_to', Auth::id())
                ->orWhere('is_all_users', true)
                ->pluck('id'))
            ->get();
        $systems = System::where('created_by', Auth::id())
            ->orWhere('assigned_to', Auth::id())
            ->orWhere('is_all_users', true)
            ->get();
        $totalManuals = $manuals->count();
        $manualsBySystem = $manuals->groupBy('system_id')->map->count();

        return view('system-manuals.index', compact('manuals', 'systems', 'totalManuals', 'manualsBySystem'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'content' => 'required|string',
                'system_id' => 'required|exists:systems,id',
            ]);

            $manual = SystemManual::create([
                'system_id' => $request->system_id,
                'title' => $request->title,
                'description' => $request->description,
                'content' => $request->content,
                'created_by' => Auth::id(),
                'updated_by' => Auth::id(),
            ]);

            return redirect()->route('system-manuals.index')->with('msg', 'Manual created successfully.');
        } catch (\Exception $e) {
            Log::error('Failed to save manual: ' . $e->getMessage(), ['request' => $request->all()]);
            return redirect()->back()->withErrors(['content' => 'Failed to save manual: ' . $e->getMessage()]);
        }
    }

    public function update(Request $request, SystemManual $systemManual)
    {
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'content' => 'required|string',
                'system_id' => 'required|exists:systems,id',
            ]);

            $systemManual->update([
                'system_id' => $request->system_id,
                'title' => $request->title,
                'description' => $request->description,
                'content' => $request->content,
                'updated_by' => Auth::id(),
            ]);

            return response()->json(['success' => 'Manual updated successfully.']);
        } catch (\Exception $e) {
            Log::error('Failed to update manual: ' . $e->getMessage(), ['request' => $request->all(), 'manual_id' => $systemManual->id]);
            return response()->json(['error' => 'Failed to update manual: ' . $e->getMessage()], 500);
        }
    }

    public function destroy(SystemManual $systemManual)
    {
        try {
            $systemManual->delete();
            return response()->json(['success' => 'Manual deleted successfully.']);
        } catch (\Exception $e) {
            Log::error('Failed to delete manual: ' . $e->getMessage(), ['manual_id' => $systemManual->id]);
            return response()->json(['error' => 'Failed to delete manual: ' . $e->getMessage()], 500);
        }
    }
}
