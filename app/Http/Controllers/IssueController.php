<?php
namespace App\Http\Controllers;

use App\Models\Issue;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IssueController extends Controller
{
    public function index(Request $request)
    {
        // Load filters
        $projects = Project::pluck('name', 'id');
        $users = User::pluck('name', 'id');
        $statuses = ['Open', 'In Progress', 'Closed'];
        $priorities = ['Low', 'Medium', 'High'];

        // Build query
        $query = Issue::with(['project', 'users', 'creator']);

        // Apply filters
        if ($request->filled('project_id')) {
            $query->where('project_id', $request->project_id);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }
        if ($request->filled('assignee')) {
            $query->whereHas('users', function ($q) use ($request) {
                $q->where('users.id', $request->assignee);
            });
        }
        if ($request->filled('creator')) {
            $query->where('created_by', $request->creator);
        }

        // Get issues
        $issues = $query->latest()->get();

        // Calculate statistics
        $stats = [
            'total_issues' => Issue::count(),
            'open_issues' => Issue::where('status', 'Open')->count(),
            'in_progress_issues' => Issue::where('status', 'In Progress')->count(),
            'closed_issues' => Issue::where('status', 'Closed')->count(),
            'low_priority_issues' => Issue::where('priority', 'Low')->count(),
            'medium_priority_issues' => Issue::where('priority', 'Medium')->count(),
            'high_priority_issues' => Issue::where('priority', 'High')->count(),
        ];

        return view('issues.index', compact('issues', 'projects', 'users', 'statuses', 'priorities', 'stats'));
    }

    public function store(Request $request, Project $project)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:Open,In Progress,Closed',
            'priority' => 'required|in:Low,Medium,High',
            'users' => 'nullable|array',
            'users.*' => 'exists:users,id',
        ]);

        $issue = Issue::create([
            'project_id' => $project->id,
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status,
            'priority' => $request->priority,
            'created_by' => Auth::id(),
        ]);

        if ($request->users) {
            $issue->users()->sync($request->users);
        }

        return redirect()->route('issues.index')->with('msg', 'Issue created successfully.');
    }

    public function update(Request $request, Issue $issue)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:Open,In Progress,Closed',
            'priority' => 'required|in:Low,Medium,High',
            'users' => 'nullable|array',
            'users.*' => 'exists:users,id',
        ]);

        $issue->update([
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status,
            'priority' => $request->priority,
        ]);

        $issue->users()->sync($request->users ?: []);

        return redirect()->route('issues.index')->with('msg', 'Issue updated successfully.');
    }

    public function destroy(Issue $issue)
    {
        $issue->users()->detach();
        $issue->delete();
        return response()->json(['success' => true, 'message' => 'Issue deleted successfully.']);
    }
}
