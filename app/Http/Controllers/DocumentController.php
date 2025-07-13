<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\DocumentVersion;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    public function index()
    {
        $documents = Document::with('latestVersion')->where('created_by', Auth::id())
            ->orWhere('assigned_to', Auth::id())
            ->get();
        $users = User::all();
        $projects = Project::all();
        return view('documents.index', compact('documents', 'users', 'projects'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'project_id' => 'nullable|exists:projects,id',
            'type' => 'required|in:project_document,template',
            'file' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'color' => 'required|string',
        ]);

        $document = Document::create([
            'title' => $request->title,
            'project_id' => $request->project_id,
            'type' => $request->type,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'color' => $request->color,
            'created_by' => Auth::id(),
        ]);

        $versionData = [
            'document_id' => $document->id,
            'version_number' => 1,
            'content' => $request->content,
            'created_by' => Auth::id(),
        ];

        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('documents', 'public');
            $versionData['file_path'] = $filePath;
        }

        DocumentVersion::create($versionData);

        return redirect()->route('documents.index')->with('msg', 'Document created successfully.');
    }

    public function update(Request $request, Document $document)
    {
        //    if (Auth::user()->role->name !== 'Admin' && $document->created_by !== Auth::id()) {
        //        return response()->json(['error' => 'Unauthorized'], 403);
        //    }

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'project_id' => 'nullable|exists:projects,id',
            'type' => 'required|in:project_document,template',
            'file' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'color' => 'required|string',
        ]);

        $document->update([
            'title' => $request->title,
            'project_id' => $request->project_id,
            'type' => $request->type,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'color' => $request->color,
        ]);

        $latestVersion = $document->latestVersion() ?? 0;
        //    $versionNumber = $latestVersion ? $latestVersion + 1 : 1;

        $versionNumber = 1;
        $versionData = [
            'document_id' => $document->id,
            'version_number' => $versionNumber,
            'content' => $request->content,
            'created_by' => Auth::id(),
        ];

        if ($request->hasFile('file')) {
            if ($latestVersion && $latestVersion->file_path) {
                Storage::disk('public')->delete($latestVersion->file_path);
            }
            $filePath = $request->file('file')->store('documents', 'public');
            $versionData['file_path'] = $filePath;
        }

        DocumentVersion::create($versionData);

        return redirect()->back()->with('success','Document updated successfully.');

        // return response()->json(['success' => 'Document updated successfully.']);
    }

    public function destroy(Document $document)
    {
        //    if (Auth::user()->role->name !== 'Admin' && $document->created_by !== Auth::id()) {
        //        return response()->json(['error' => 'Unauthorized'], 403);
        //    }

        foreach ($document->versions as $version) {
            if ($version->file_path) {
                Storage::disk('public')->delete($version->file_path);
            }
        }

        $document->delete();
        return response()->json(['success' => 'Document deleted successfully.']);
    }

    public function storeForUser(Request $request)
    {
        if (Auth::user()->role->name !== 'Admin') {
            return redirect()->route('documents.index')->with('error', 'Unauthorized');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'project_id' => 'nullable|exists:projects,id',
            'type' => 'required|in:project_document,template',
            'file' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'color' => 'required|string',
            'assigned_to' => 'required|exists:users,id',
        ]);

        $document = Document::create([
            'title' => $request->title,
            'project_id' => $request->project_id,
            'type' => $request->type,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'color' => $request->color,
            'created_by' => Auth::id(),
            'assigned_to' => $request->assigned_to,
        ]);

        $versionData = [
            'document_id' => $document->id,
            'version_number' => 1,
            'content' => $request->content,
            'created_by' => Auth::id(),
        ];

        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('documents', 'public');
            $versionData['file_path'] = $filePath;
        }

        DocumentVersion::create($versionData);

        return redirect()->route('documents.index')->with('msg', 'Document assigned successfully.');
    }

    public function data()
    {
        $documents = Document::with('latestVersion')->where('created_by', Auth::id())
            ->orWhere('assigned_to', Auth::id())
            ->get();

        $events = $documents->map(function ($document) {
            $latestVersion = $document->latestVersion();
            return [
                'id' => $document->id,
                'title' => $document->title,
                'start' => $document->start_date->toIso8601String(),
                'end' => $document->end_date?->toIso8601String(),
                'backgroundColor' => $document->color,
                'borderColor' => $document->color,
                'extendedProps' => [
                    'description' => $latestVersion->content ?? '-',
                    'creator' => $document->creator->name,
                    'assignee' => $document->assignee?->name ?? '-',
                    'project' => $document->project?->name ?? '-',
                    'type' => ucwords(str_replace('_', ' ', $document->type)),
                    'version_number' => $latestVersion->version_number ?? 1,
                ],
            ];
        });

        return response()->json($events);
    }

    public function showVersions(Document $document)
    {
        //    if (Auth::user()->role->name !== 'Admin' && $document->created_by !== Auth::id() && $document->assigned_to !== Auth::id()) {
        //        abort(403, 'Unauthorized');
        //    }

        return view('documents.versions', compact('document'));
    }
}
