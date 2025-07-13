<?php
namespace App\Http\Controllers;

use App\Models\SecurityGap;
use App\Models\SecurityGapTemplate;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SecurityGapController extends Controller
{
    public function index()
    {
        $securityGaps = SecurityGap::with('template')->where('created_by', Auth::id())
            ->orWhere('assigned_to', Auth::id())
            ->get();
        $users = User::all();
        $projects = Project::all();
        $templates = SecurityGapTemplate::all();
        return view('security_gaps.index', compact('securityGaps', 'users', 'projects', 'templates'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'security_gap_template_id' => 'nullable|exists:security_gap_templates,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'project_id' => 'required|exists:projects,id',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'color' => 'required|string',
        ]);

        $template = SecurityGapTemplate::find($request->security_gap_template_id);
        SecurityGap::create([
            'security_gap_template_id' => $request->security_gap_template_id,
            'title' => $request->title ?? $template?->title,
            'description' => $request->description ?? $template?->description,
            'project_id' => $request->project_id,
            'status' => 'open',
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'color' => $request->color,
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('security-gaps.index')->with('msg', 'Security Gap created successfully.');
    }

    public function update(Request $request, SecurityGap $securityGap)
    {
        if (Auth::user()->role->name !== 'Admin' && $securityGap->created_by !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $request->validate([
            'security_gap_template_id' => 'nullable|exists:security_gap_templates,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'project_id' => 'required|exists:projects,id',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'color' => 'required|string',
            'status' => 'required|in:open,in_progress,mitigated,verified',
        ]);

        $securityGap->update([
            'security_gap_template_id' => $request->security_gap_template_id,
            'title' => $request->title,
            'description' => $request->description,
            'project_id' => $request->project_id,
            'status' => $request->status,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'color' => $request->color,
        ]);

        return response()->json(['success' => 'Security Gap updated successfully.']);
    }

    public function destroy(SecurityGap $securityGap)
    {
        if (Auth::user()->role->name !== 'Admin' && $securityGap->created_by !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $securityGap->delete();
        return response()->json(['success' => 'Security Gap deleted successfully.']);
    }

    public function storeForUser(Request $request)
    {
        if (Auth::user()->role->name !== 'Admin') {
            return redirect()->route('security-gaps.index')->with('error', 'Unauthorized');
        }

        $request->validate([
            'security_gap_template_id' => 'nullable|exists:security_gap_templates,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'project_id' => 'required|exists:projects,id',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'color' => 'required|string',
            'assigned_to' => 'required|exists:users,id',
        ]);

        $template = SecurityGapTemplate::find($request->security_gap_template_id);
        SecurityGap::create([
            'security_gap_template_id' => $request->security_gap_template_id,
            'title' => $request->title ?? $template?->title,
            'description' => $request->description ?? $template?->description,
            'project_id' => $request->project_id,
            'status' => 'open',
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'color' => $request->color,
            'created_by' => Auth::id(),
            'assigned_to' => $request->assigned_to,
        ]);

        return redirect()->route('security-gaps.index')->with('msg', 'Security Gap assigned successfully.');
    }

    public function data()
    {
        $securityGaps = SecurityGap::with('template')->where('created_by', Auth::id())
            ->orWhere('assigned_to', Auth::id())
            ->get();

        $events = $securityGaps->map(function ($securityGap) {
            return [
                'id' => $securityGap->id,
                'title' => $securityGap->title,
                'start' => $securityGap->start_date->toIso8601String(),
                'end' => $securityGap->end_date?->toIso8601String(),
                'backgroundColor' => $securityGap->color,
                'borderColor' => $securityGap->color,
                'extendedProps' => [
                    'description' => $securityGap->description,
                    'creator' => $securityGap->creator->name,
                    'assignee' => $securityGap->assignee?->name ?? '-',
                    'project' => $securityGap->project->name,
                    'status' => $securityGap->status,
                    'template' => $securityGap->template?->title ?? '-',
                ],
            ];
        });

        return response()->json($events);
    }
}
