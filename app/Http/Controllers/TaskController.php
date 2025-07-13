<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use App\Models\Project;
use App\Imports\TasksImport;
use Illuminate\Http\Request;
use App\Exports\ProjectTasksExport;
use App\Exports\TasksTemplateExport;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class TaskController extends Controller
{
   public function index(Request $request)
    {
        $query = Task::with(['project', 'creator', 'users']);

        // Apply filters
        if ($request->filled('project_id')) {
            $query->where('project_id', $request->project_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('user_id')) {
            $query->whereHas('users', function ($q) use ($request) {
                $q->where('user_id', $request->user_id);
            });
        }

        $tasks = $query->get();
        $projects = Project::where('status', 'active')->get();
        $users = User::all();

        return view('tasks.index', compact('tasks', 'projects', 'users'));
    }


    public function assigned()
    {
        $tasks = Task::whereHas('users', function ($query) {
            $query->where('user_id', Auth::id());
        })->with(['project', 'creator', 'users'])->get();
        return view('tasks.assigned', compact('tasks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'project_id' => 'nullable|exists:projects,id',
            'due_date' => 'nullable|date',
            'users' => 'array',
        ]);

        $task = Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'project_id' => $request->project_id,
            'creator_id' => Auth::id(),
            'due_date' => $request->due_date,
        ]);

        if ($request->users) {
            $task->users()->sync($request->users);
        }

        return redirect()->route('tasks.index')->with('success', 'Task created.');
    }

    public function update(Request $request, Task $task)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'project_id' => 'nullable|exists:projects,id',
            'due_date' => 'nullable|date',
            'users' => 'array',
        ]);

        $task->update([
            'title' => $request->title,
            'description' => $request->description,
            'project_id' => $request->project_id,
            'due_date' => $request->due_date,
        ]);

        $task->users()->sync($request->users ?? []);

        return redirect()->route('tasks.index')->with('success', 'Task updated.');
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->route('tasks.index')->with('success', 'Task deleted.');
    }

    public function view(Task $task)
    {
        $task->load(['project', 'creator', 'users', 'subtasks', 'comments.user', 'attachments.user', 'remarks.user', 'review']);
        $projects = Project::where('status', 'active')->get();
        $users = User::all();
        return view('tasks.view', compact('task', 'projects', 'users'));
    }

    public function markCompleted(Request $request, Task $task)
    {
        $request->validate(['status' => 'required|in:completed']);
        if ($task->users()->where('user_id', Auth::id())->exists()) {
            $task->update(['status' => 'under_review']);
            return redirect()->route('tasks.view', $task)->with('success', 'Task marked as completed, pending review.');
        }
        return redirect()->route('tasks.view', $task)->with('error', 'Unauthorized action.');
    }

    public function exportTemplate()
    {
        return Excel::download(new TasksTemplateExport, 'tasks_template.xlsx');
    }

        public function exportTasks(Request $request)
    {
        $request->validate([
            'export_project_id' => 'required|exists:projects,id',
        ]);

        $projectId = $request->input('export_project_id');
        $project = Project::findOrFail($projectId);
        $fileName = "tasks_project_{$project->name}.xlsx";
        return Excel::download(new ProjectTasksExport($projectId), $fileName);
    }


    public function import(Request $request)
    {
        $request->validate(['file' => 'required|mimes:xlsx']);
        Excel::import(new TasksImport, $request->file('file'));
        return redirect()->route('tasks.index')->with('success', 'Tasks imported successfully.');
    }
}
