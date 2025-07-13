<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'commentable_id' => 'required',
            'commentable_type' => 'required|in:App\Models\Task,App\Models\Subtask',
            'content' => 'required|string',
        ]);

        Comment::create([
            'commentable_id' => $request->commentable_id,
            'commentable_type' => $request->commentable_type,
            'user_id' => Auth::id(),
            'content' => $request->content,
        ]);

        return redirect()->back()->with('success', 'Comment added.');
    }

    public function destroy(Comment $comment)
    {
        $this->authorize('delete', $comment);
        $comment->delete();
        return redirect()->back()->with('success', 'Comment deleted.');
    }
}
