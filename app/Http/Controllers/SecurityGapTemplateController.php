<?php
   namespace App\Http\Controllers;

   use App\Models\SecurityGapTemplate;
   use Illuminate\Http\Request;
   use Illuminate\Support\Facades\Auth;

   class SecurityGapTemplateController extends Controller
   {
       public function index()
       {
           $templates = SecurityGapTemplate::all();
           return view('security_gap_templates.index', compact('templates'));
       }

       public function store(Request $request)
       {
           $request->validate([
               'title' => 'required|string|max:255',
               'description' => 'nullable|string',
           ]);

           $latestTemplate = SecurityGapTemplate::where('title', $request->title)->orderBy('version_number', 'desc')->first();
           $versionNumber = $latestTemplate ? $latestTemplate->version_number + 1 : 1;

           SecurityGapTemplate::create([
               'title' => $request->title,
               'description' => $request->description,
               'version_number' => $versionNumber,
               'created_by' => Auth::id(),
           ]);

           return redirect()->route('security-gap-templates.index')->with('msg', 'Template created successfully.');
       }

       public function update(Request $request, SecurityGapTemplate $template)
       {
           $request->validate([
               'title' => 'required|string|max:255',
               'description' => 'nullable|string',
           ]);

           $template->update([
               'title' => $request->title,
               'description' => $request->description,
               'version_number' => $template->version_number + 1,
           ]);

           return redirect()->route('security-gap-templates.index')->with('msg', 'Template updated successfully.');
       }

       public function destroy(SecurityGapTemplate $template)
       {
           $template->delete();
           return redirect()->route('security-gap-templates.index')->with('msg', 'Template deleted successfully.');
       }
   }
