<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Subtask;
use App\Models\TaskUpdate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskUpdateController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'updatable_id' => 'required',
            'updatable_type' => 'required|in:App\Models\Task,App\Models\Subtask',
            'content' => 'required|string',
        ]);

        $model = $request->updatable_type::findOrFail($request->updatable_id);

        // Check if user is assigned to the task (or its parent task for subtasks)
        $isAssigned = $request->updatable_type === Task::class
            ? $model->users->contains(Auth::id())
            : $model->task->users->contains(Auth::id());

        // Check if task/subtask is not locked
        if (!$isAssigned || in_array($model->status, ['under_review', 'approved'])) {
            return redirect()->back()->with('error', 'You cannot update this task or subtask.');
        }

        TaskUpdate::create([
            'updatable_id' => $request->updatable_id,
            'updatable_type' => $request->updatable_type,
            'user_id' => Auth::id(),
            'content' => $request->content,
        ]);

        return redirect()->back()->with('success', 'Update added.');
    }
}
