<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskReviewController extends Controller
{
    public function store(Request $request, Task $task)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review_comments' => 'nullable|string',
            'approved' => 'required|boolean',
        ]);

        if ($task->creator_id !== Auth::id()) {
            return redirect()->route('tasks.view', $task)->with('error', 'Only the task creator can review.');
        }

        TaskReview::updateOrCreate(
            ['task_id' => $task->id, 'reviewer_id' => Auth::id()],
            [
                'rating' => $request->rating,
                'review_comments' => $request->review_comments,
                'approved_at' => $request->approved ? now() : null,
            ]
        );

        $task->update(['status' => $request->approved ? 'approved' : 'completed']);

        return redirect()->route('tasks.view', $task)->with('success', 'Task reviewed.');
    }
}
