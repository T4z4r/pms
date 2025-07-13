<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AttachmentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'attachable_id' => 'required',
            'attachable_type' => 'required|in:App\Models\Task,App\Models\Subtask',
            'file' => 'required|file|max:10240', // 10MB max
        ]);

        $file = $request->file('file');
        $path = $file->store('attachments', 'public');

        Attachment::create([
            'attachable_id' => $request->attachable_id,
            'attachable_type' => $request->attachable_type,
            'user_id' => Auth::id(),
            'file_path' => $path,
            'file_name' => $file->getClientOriginalName(),
        ]);

        return redirect()->back()->with('success', 'Attachment uploaded.');
    }

    public function destroy(Attachment $attachment)
    {
        $this->authorize('delete', $attachment);
        Storage::disk('public')->delete($attachment->file_path);
        $attachment->delete();
        return redirect()->back()->with('success', 'Attachment deleted.');
    }
}
