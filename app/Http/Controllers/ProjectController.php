<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Issue;
use App\Models\Client;
use App\Models\Project;
use App\Models\ProjectTag;
use App\Models\ProjectRole;
use App\Models\ProjectType;
use Illuminate\Http\Request;
use App\Models\ProjectPriority;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    // public function index()
    // {
    //     // $projects = Project::with(relations: 'client', 'creator', 'updater')
    //     //     ->where('created_by', Auth::id())
    //     //     ->orWhere('assigned_to', Auth::id())
    //     //     ->orWhere('is_all_users', true)
    //     //     ->get();
    //     $clients = Client::all();
    //     // return view('projects.index', compact('projects', 'clients'));

    //     $projects = Project::with(['client', 'projectType', 'projectPriority', 'tags'])->get();
    //     $types = ProjectType::where('status', 'active')->get();
    //     $priorities = ProjectPriority::where('status', 'active')->get();
    //     $tags = ProjectTag::where('status', 'active')->get();
    //     $roles = ProjectRole::where('status', 'active')->get();
    //     $users = User::all();
    //     return view('projects.index', compact('projects', 'types', 'priorities', 'tags', 'roles', 'users','clients'));
    // }

    public function index(Request $request)
    {
        $projects = Project::with(['client', 'projectType', 'projectPriority', 'tags', 'roles', 'users'])->get();
        $clients = Client::all();
        $types = ProjectType::all();
        $priorities = ProjectPriority::all();
        $tags = ProjectTag::where('status', 'active')->get();
        $roles = ProjectRole::where('status', 'active')->get();
        $users = User::all();

        // Project statistics
        $totalProjects = $projects->count();
        $activeProjects = $projects->where('status', 'active')->count();
        $highPriorityProjects = Project::whereHas('projectPriority', function ($query) {
            $query->where('name', 'like', 'High');
        })->count();

        return view('projects.index', compact(
            'projects',
            'clients',
            'types',
            'priorities',
            'tags',
            'roles',
            'users',
            'totalProjects',
            'activeProjects',
            'highPriorityProjects'
        ));
    }

    public function create()
    {
        $types = ProjectType::where('status', 'active')->get();
        $priorities = ProjectPriority::where('status', 'active')->get();
        $tags = ProjectTag::where('status', 'active')->get();
        $roles = ProjectRole::where('status', 'active')->get();
        $users = User::all();
        $clients = Client::all();
        return view('projects.create', compact('types', 'priorities', 'tags', 'roles', 'users', 'clients'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'project_type_id' => 'required|exists:project_types,id',
            'project_priority_id' => 'required|exists:project_priorities,id',
            'status' => 'required|in:active,inactive',
            'tags' => 'array',
            'roles' => 'array',
            'users' => 'array',
            'client_id' => 'nullable'
        ]);

        $request['created_by'] = Auth::user()->id;
        $project = Project::create($request->only(['name', 'description', 'project_type_id', 'project_priority_id', 'status', 'client_id', 'created_by']));
        $project->tags()->sync($request->tags);
        if ($request->roles && $request->users) {
            foreach ($request->users as $userId) {
                foreach ($request->roles as $roleId) {
                    $project->users()->attach($userId, ['project_role_id' => $roleId]);
                }
            }
        }

        return redirect()->route('projects.index')->with('success', 'Project created.');
    }

    public function edit(Project $project)
    {
        $types = ProjectType::where('status', 'active')->get();
        $priorities = ProjectPriority::where('status', 'active')->get();
        $tags = ProjectTag::where('status', 'active')->get();
        $roles = ProjectRole::where('status', 'active')->get();
        $users = User::all();
        return view('projects.edit', compact('project', 'types', 'priorities', 'tags', 'roles', 'users'));
    }

    public function update(Request $request, Project $project)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'project_type_id' => 'required|exists:project_types,id',
            'project_priority_id' => 'required|exists:project_priorities,id',
            'status' => 'required|in:active,inactive',
            'tags' => 'array',
            'roles' => 'array',
            'users' => 'array',
            'client_id' => 'nullable'
        ]);
        $request['created_by'] = Auth::user()->id;
        $project->update($request->only(['name', 'description', 'project_type_id', 'project_priority_id', 'status', 'client_id', 'created_by']));
        $project->tags()->sync($request->tags);
        $project->users()->detach();
        if ($request->roles && $request->users) {
            foreach ($request->users as $userId) {
                foreach ($request->roles as $roleId) {
                    $project->users()->attach($userId, ['project_role_id' => $roleId]);
                }
            }
        }

        return redirect()->route('projects.index')->with('success', 'Project updated.');
    }

    public function destroy(Project $project)
    {
        $project->delete();
        return redirect()->route('projects.index')->with('success', 'Project deleted.');
    }


    // public function view(Project $project)
    // {
    //     $project->load(['projectType', 'projectPriority', 'tags', 'users', 'roles', 'ratings.user', 'traceMetrics']);
    //     $types = ProjectType::latest()->get();
    //     $priorities = ProjectPriority::where('status', 'active')->get();
    //     $tags = ProjectTag::where('status', 'active')->get();
    //     $roles = ProjectRole::where('status', 'active')->get();
    //     $users = User::all();
    //     return view('projects.view', compact('project', 'types', 'priorities', 'tags', 'roles', 'users'));
    // }

    public function view(Project $project)
    {
        $project->load([
            'projectType',
            'projectPriority',
            'tags',
            'users',
            'roles',
            'ratings.user',
            'traceMetrics',
            'issues.users',
            'issues.creator'
        ]);
        $types = ProjectType::latest()->get();
        $priorities = ProjectPriority::where('status', 'active')->get();
        $tags = ProjectTag::where('status', 'active')->get();
        $roles = ProjectRole::where('status', 'active')->get();
        $users = User::all();

        // Issue statistics
        $stats = [
            'total_issues' => $project->issues->count(),
            'open_issues' => $project->issues->where('status', 'Open')->count(),
            'in_progress_issues' => $project->issues->where('status', 'In Progress')->count(),
            'closed_issues' => $project->issues->where('status', 'Closed')->count(),
            'low_priority_issues' => $project->issues->where('priority', 'Low')->count(),
            'medium_priority_issues' => $project->issues->where('priority', 'Medium')->count(),
            'high_priority_issues' => $project->issues->where('priority', 'High')->count(),
            'team_size' => $project->users->count(),
            'average_rating' => $project->ratings->avg('rating') ?: 0,
        ];

        return view('projects.view', compact('project', 'types', 'priorities', 'tags', 'roles', 'users', 'stats'));
    }

    public function issues(Project $project)
    {
        $issues = $project->issues()->with('users', 'creator')->get();
        $users = User::all();
        return view('projects.issues', compact('project', 'issues', 'users'));
    }

    public function storeIssue(Request $request, Project $project)
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

        return redirect()->route('projects.index')->with('msg', 'Issue created successfully.');
    }

    public function updateIssue(Request $request, Issue $issue)
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

        return redirect()->route('projects.index')->with('msg', 'Issue updated successfully.');
    }

    public function destroyIssue(Issue $issue)
    {
        $issue->users()->detach(); // Clear user assignments
        $issue->delete();
        return response()->json(['success' => true, 'message' => 'Issue deleted successfully.']);
    }
}
