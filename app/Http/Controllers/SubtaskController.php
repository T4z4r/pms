<?php

namespace App\Http\Controllers;

use App\Models\Subtask;
use App\Models\Task;
use Illuminate\Http\Request;

class SubtaskController extends Controller
{
    public function store(Request $request, Task $task)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'due_date' => 'nullable|date',
        ]);

        $task->subtasks()->create([
            'title' => $request->title,
            'description' => $request->description,
            'due_date' => $request->due_date,
        ]);

        return redirect()->route('tasks.view', $task)->with('success', 'Subtask created.');
    }

    public function update(Request $request, Subtask $subtask)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'due_date' => 'nullable|date',
        ]);

        $subtask->update([
            'title' => $request->title,
            'description' => $request->description,
            'due_date' => $request->due_date,
        ]);

        return redirect()->route('tasks.view', $subtask->task)->with('success', 'Subtask updated.');
    }

    public function destroy(Subtask $subtask)
    {
        $task = $subtask->task;
        $subtask->delete();
        return redirect()->route('tasks.view', $task)->with('success', 'Subtask deleted.');
    }

    public function markCompleted(Request $request, Subtask $subtask)
    {
        $request->validate(['status' => 'required|in:completed']);
        $subtask->update(['status' => 'under_review']);
        return redirect()->route('tasks.view', $subtask->task)->with('success', 'Subtask marked as completed, pending review.');
    }
}
