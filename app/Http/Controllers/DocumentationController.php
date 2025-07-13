<?php

namespace App\Http\Controllers;

use App\Models\Documentation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Spatie\Permission\Traits\HasRoles;

class DocumentationController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('role:admin')->only(['destroy']);
    // }

    public function index()
    {
        $documentations = Documentation::with('user')->get();
        return view('documentations.index', compact('documentations'));
    }

    public function create()
    {
        return view('documentations.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'topic' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        Documentation::create([
            'user_id' => Auth::id(),
            ...$validated,
        ]);

        return redirect()->route('documentations.index')->with('msg', 'Documentation created successfully.');
    }

    public function show(Documentation $documentation)
    {
        return view('documentations.show', compact('documentation'));
    }

    public function edit(Documentation $documentation)
    {
        $this->authorize('update', $documentation);
        return view('documentations.edit', compact('documentation'));
    }

    public function update(Request $request, Documentation $documentation)
    {
        $this->authorize('update', $documentation);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'topic' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $documentation->update($validated);

        return redirect()->route('documentations.index')->with('msg', 'Documentation updated successfully.');
    }

    public function destroy(Documentation $documentation)
    {
        $this->authorize('delete', $documentation);
        $documentation->delete();
        return redirect()->route('documentations.index')->with('msg', 'Documentation deleted successfully.');
    }

    public function download(Documentation $documentation)
    {
        $pdf = Pdf::loadView('documentations.pdf', compact('documentation'));
        return $pdf->download($documentation->title . '.pdf');
    }
}