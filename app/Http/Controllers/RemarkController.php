<?php

namespace App\Http\Controllers;

use App\Models\Remark;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RemarkController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'remarkable_id' => 'required',
            'remarkable_type' => 'required|in:App\Models\Task,App\Models\Subtask',
            'content' => 'required|string',
        ]);

        Remark::create([
            'remarkable_id' => $request->remarkable_id,
            'remarkable_type' => $request->remarkable_type,
            'user_id' => Auth::id(),
            'content' => $request->content,
        ]);

        return redirect()->back()->with('success', 'Remark added.');
    }

    public function destroy(Remark $remark)
    {
        $this->authorize('delete', $remark);
        $remark->delete();
        return redirect()->back()->with('success', 'Remark deleted.');
    }
}
