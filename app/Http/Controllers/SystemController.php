<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Module;
use App\Models\System;
use App\Models\Feature;
use App\Models\Project;
use App\Models\Submodule;
use App\Models\Requirement;
use Illuminate\Http\Request;
use App\Exports\SystemExport;
use App\Exports\FeaturesExport;
use Barryvdh\DomPDF\Facade\PDF;
use App\Exports\RequirementsExport;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

class SystemController extends Controller
{
    public function index()
    {
        $systems = System::with('features', 'requirements', 'projects')->where('created_by', Auth::id())
            ->orWhere('assigned_to', Auth::id())
            ->orWhere('is_all_users', true)
            ->get();
        $users = User::all();
        $projects = Project::all();
        return view('systems.index', compact('systems', 'users', 'projects'));
    }

    public function show(System $system)
    {
        $system->load('features.module', 'features.submodule', 'requirements', 'projects', 'creator', 'assignee');
        return view('systems.view', compact('system'));
    }

    // public function show(System $system)
    // {
    //     // Load only the system and minimal relations initially
    //     $system->load('creator', 'assignee');
    //     return view('systems.view', compact('system'));
    // }

    public function showProjects(System $system)
    {
        $system->load('projects.creator', 'projects.assignee');
        return view('systems.projects', compact('system'));
    }

    public function showModules(System $system)
    {
        $system->load('modules');
        return view('systems.modules', compact('system'));
    }

    public function showSubmodules(System $system)
    {
        $submodules = Submodule::whereIn('module_id', $system->modules->pluck('id'))->with('module')->get();
        return view('systems.submodules', compact('system', 'submodules'));
    }

    public function showFeatures(System $system)
    {
        $features = $system->features()
        ->with(['module', 'submodule', 'creator'])
        ->latest()
        ->limit(4)
        ->get();

        return view('systems.features', compact('system','features'));
    }

    public function showRequirements(System $system)
    {
        $system->load('requirements.creator');
        return view('systems.requirements', compact('system'));
    }

    // In SystemController.php
    public function getProjects(System $system, Request $request)
    {
        $query = $system->projects()
            ->with(['creator', 'assignee'])
            ->select(['id', 'name', 'description', 'type', 'status', 'start_date', 'end_date', 'created_at', 'creator_id', 'assignee_id', 'is_all_users']);

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('description', fn($project) => Str::limit(strip_tags($project->description ?? ''), 50))
            ->addColumn('type', fn($project) => ucwords(str_replace('_', ' ', $project->type)))
            ->addColumn('status', fn($project) => ucwords(str_replace('_', ' ', $project->status)))
            ->addColumn('start_date', fn($project) => $project->start_date?->format('Y-m-d H:i') ?? '--')
            ->addColumn('end_date', fn($project) => $project->end_date?->format('Y-m-d H:i') ?? '--')
            ->addColumn('creator', fn($project) => $project->creator?->name ?? '--')
            ->addColumn('assignee', fn($project) => $project->assignee?->name ?? ($project->is_all_users ? 'All Users' : '-'))
            ->addColumn('options', fn($project) => '
            <a href="' . url('projects.show', $project->id) . '" title="View Project" class="btn btn-sm btn-main">
                <i class="ph-info"></i>
            </a>')
            ->rawColumns(['description', 'options'])
            ->make(true);
    }

    // Fetch modules for DataTable
    public function getModules(System $system, Request $request)
    {
        $query = $system->modules()
            ->select(['id', 'name', 'description', 'order', 'created_at']);

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('description', fn($module) => Str::limit(strip_tags($module->description ?? ''), 50))
            ->addColumn('created_at', fn($module) => $module->created_at->format('Y-m-d H:i'))
            ->addColumn('options', fn($module) => '
                <button class="btn btn-sm btn-main me-1 edit-module" data-item="' . htmlspecialchars(json_encode([
                'id' => $module->id,
                'name' => $module->name,
                'description' => $module->description,
                'order' => $module->order ?? 0
            ])) . '" title="Edit Module">
                    <i class="ph-note-pencil"></i>
                </button>
                <button class="btn btn-sm btn-danger" onclick="deleteModule(' . $module->id . ')" title="Delete Module">
                    <i class="ph-trash"></i>
                </button>')
            ->rawColumns(['description', 'options'])
            ->make(true);
    }

    // Fetch submodules for DataTable
    public function getSubmodules(System $system, Request $request)
    {
        $query = \App\Models\Submodule::whereIn('module_id', $system->modules()->pluck('id'))
            ->with('module')
            ->select(['submodules.id', 'submodules.name', 'submodules.description', 'submodules.module_id', 'submodules.created_at']);

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('module', fn($submodule) => $submodule->module->name ?? 'N/A')
            ->addColumn('description', fn($submodule) => Str::limit(strip_tags($submodule->description ?? ''), 50))
            ->addColumn('created_at', fn($submodule) => $submodule->created_at->format('Y-m-d H:i'))
            ->addColumn('options', fn($submodule) => '
                <button class="btn btn-sm btn-main me-1 edit-submodule" data-item="' . htmlspecialchars(json_encode([
                'id' => $submodule->id,
                'name' => $submodule->name,
                'description' => $submodule->description,
                'module_id' => $submodule->module_id
            ])) . '" title="Edit Submodule">
                    <i class="ph-note-pencil"></i>
                </button>
                <button class="btn btn-sm btn-danger" onclick="deleteSubmodule(' . $submodule->id . ')" title="Delete Submodule">
                    <i class="ph-trash"></i>
                </button>')
            ->rawColumns(['description', 'options'])
            ->make(true);
    }

    // Fetch features for DataTable
    public function getFeatures(System $system, Request $request)
    {
        $query = $system->features()
            ->with(['module', 'submodule', 'creator'])
            ->select(['features.id', 'features.title', 'features.description', 'features.status', 'features.module_id', 'features.submodule_id', 'features.creator_id', 'features.created_at']);

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('module', fn($feature) => $feature->module->name ?? 'N/A')
            ->addColumn('submodule', fn($feature) => $feature->submodule->name ?? 'N/A')
            ->addColumn('description', fn($feature) => Str::limit(strip_tags($feature->description ?? ''), 50))
            ->addColumn('status', fn($feature) => ucwords(str_replace('_', ' ', $feature->status)))
            ->addColumn('creator', fn($feature) => $feature->creator?->name ?? '--')
            ->addColumn('created_at', fn($feature) => $feature->created_at->format('Y-m-d H:i'))
            ->addColumn('options', fn($feature) => '
                <button class="btn btn-sm btn-main me-1 edit-feature" data-item="' . htmlspecialchars(json_encode([
                'id' => $feature->id,
                'title' => $feature->title,
                'description' => $feature->description,
                'module_id' => $feature->module_id,
                'submodule_id' => $feature->submodule_id,
                'status' => $feature->status
            ])) . '" title="Edit Feature">
                    <i class="ph-note-pencil"></i>
                </button>
                <button class="btn btn-sm btn-danger" onclick="deleteFeature(' . $feature->id . ')" title="Delete Feature">
                    <i class="ph-trash"></i>
                </button>')
            ->rawColumns(['description', 'options'])
            ->make(true);
    }

    // Fetch requirements for DataTable
    public function getRequirements(System $system, Request $request)
    {
        $query = $system->requirements()
            ->with('creator')
            ->select(['requirements.id', 'requirements.title', 'requirements.description', 'requirements.priority', 'requirements.status', 'requirements.creator_id', 'requirements.created_at']);

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('description', fn($requirement) => Str::limit(strip_tags($requirement->description ?? ''), 50))
            ->addColumn('priority', fn($requirement) => ucwords($requirement->priority))
            ->addColumn('status', fn($requirement) => ucwords(str_replace('_', ' ', $requirement->status)))
            ->addColumn('creator', fn($requirement) => $requirement->creator?->name ?? '--')
            ->addColumn('created_at', fn($requirement) => $requirement->created_at->format('Y-m-d H:i'))
            ->addColumn('options', fn($requirement) => '
                <button class="btn btn-sm btn-main me-1 edit-requirement" data-item="' . htmlspecialchars(json_encode([
                'id' => $requirement->id,
                'title' => $requirement->title,
                'description' => $requirement->description,
                'priority' => $requirement->priority,
                'status' => $requirement->status
            ])) . '" title="Edit Requirement">
                    <i class="ph-note-pencil"></i>
                </button>
                <button class="btn btn-sm btn-danger" onclick="deleteRequirement(' . $requirement->id . ')" title="Delete Requirement">
                    <i class="ph-trash"></i>
                </button>')
            ->rawColumns(['description', 'options'])
            ->make(true);
    }

    public function storeFeature(Request $request, System $system)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:planned,in_progress,completed,on_hold',
            'module_id' => 'nullable|exists:modules,id',
            'submodule_id' => 'nullable|exists:submodules,id',
        ]);

        $system->features()->create([
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status,
            'module_id' => $request->module_id,
            'submodule_id' => $request->submodule_id,
            'creator_id' => auth()->id(),
            'created_by' => auth()->id(),
        ]);

        return back()->with('msg', 'Feature added successfully.');
    }

    public function updateFeature(Request $request, System $system, Feature $feature)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:planned,in_progress,completed,on_hold',
            'module_id' => 'nullable|exists:modules,id',
            'submodule_id' => 'nullable|exists:submodules,id',
        ]);

        $feature->update([
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status,
            'module_id' => $request->module_id,
            'submodule_id' => $request->submodule_id,
        ]);

        return back()->with('msg', 'Feature updated successfully.');
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'project_ids' => 'required|array',
            'project_ids.*' => 'exists:projects,id',
            'status' => 'required|in:active,inactive,under_development,deprecated',
        ]);

        $system = System::create([
            'name' => $request->name,
            'description' => $request->description,
            'status' => $request->status,
            'created_by' => Auth::id(),
        ]);

        $system->projects()->sync($request->project_ids);

        return redirect()->route('systems.index')->with('msg', 'System created successfully.');
    }

    public function update(Request $request, System $system)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'project_ids' => 'required|array',
            'project_ids.*' => 'exists:projects,id',
            'status' => 'required|in:active,inactive,under_development,deprecated',
        ]);

        $system->update([
            'name' => $request->name,
            'description' => $request->description,
            'status' => $request->status,
        ]);

        $system->projects()->sync($request->project_ids);

        return back()->with('success', 'System updated successfully.');
    }

    public function destroy(System $system)
    {
        $system->delete();
        return response()->json(['success' => 'System deleted successfully.']);
    }

    public function storeForUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'project_ids' => 'required|array',
            'project_ids.*' => 'exists:projects,id',
            'status' => 'required|in:active,inactive,under_development,deprecated',
            'assigned_to' => 'required|exists:users,id',
        ]);

        $system = System::create([
            'name' => $request->name,
            'description' => $request->description,
            'status' => $request->status,
            'created_by' => Auth::id(),
            'assigned_to' => $request->assigned_to,
        ]);

        $system->projects()->sync($request->project_ids);

        return redirect()->route('systems.index')->with('msg', 'System assigned successfully.');
    }

    public function storeForAll(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'project_ids' => 'required|array',
            'project_ids.*' => 'exists:projects,id',
            'status' => 'required|in:active,inactive,under_development,deprecated',
        ]);

        $system = System::create([
            'name' => $request->name,
            'description' => $request->description,
            'status' => $request->status,
            'created_by' => Auth::id(),
            'is_all_users' => true,
        ]);

        $system->projects()->sync($request->project_ids);

        return redirect()->route('systems.index')->with('msg', 'System assigned to all users successfully.');
    }

    public function storeFeature1(Request $request, System $system)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'status' => 'required|in:planned,in_progress,completed,on_hold',
        ]);

        Feature::create([
            'system_id' => $system->id,
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status,
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('systems.show', $system)->with('msg', 'Feature added successfully.');
    }

    public function updateFeature1(Request $request, System $system, Feature $feature)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'status' => 'required|in:planned,in_progress,completed,on_hold',
        ]);

        $feature->update([
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status,
        ]);

        return response()->json(['success' => 'Feature updated successfully.']);
    }

    public function destroyFeature(System $system,  $featureIid)
    {
        $feature = Feature::where('id', operator: $featureIid)->first();
        $feature->delete();
        return response()->json(['success' => 'Feature deleted successfully.']);
    }

    public function storeRequirement(Request $request, System $system)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'priority' => 'required|in:low,medium,high',
            'status' => 'required|in:pending,approved,rejected,implemented',
        ]);

        Requirement::create([
            'system_id' => $system->id,
            'title' => $request->title,
            'description' => $request->description,
            'priority' => $request->priority,
            'status' => $request->status,
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('systems.show', $system)->with('msg', 'Requirement added successfully.');
    }

    public function updateRequirement(Request $request, System $system, Requirement $requirement)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'priority' => 'required|in:low,medium,high',
            'status' => 'required|in:pending,approved,rejected,implemented',
        ]);

        $requirement->update([
            'title' => $request->title,
            'description' => $request->description,
            'priority' => $request->priority,
            'status' => $request->status,
        ]);

        return response()->json(['success' => 'Requirement updated successfully.']);
    }

    public function destroyRequirement(System $system, Requirement $requirement)
    {
        $requirement->delete();
        return response()->json(['success' => 'Requirement deleted successfully.']);
    }

    public function exportExcel(System $system)
    {
        return Excel::download(new SystemExport($system->id), 'system_' . $system->id . '_details.xlsx');
    }

    public function exportPdf(System $system)
    {
        $system->load('features', 'requirements', 'projects', 'creator', 'assignee');
        $pdf = FacadePdf::loadView('systems.pdf', compact('system'));
        return $pdf->download('system_' . $system->id . '_details.pdf');
    }



    public function storeModule(Request $request, System $system)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'order' => 'nullable|integer|min:0',
        ]);

        $order = $request->order ?? ($system->modules()->max('order') + 1) ?? 0;

        $system->modules()->create([
            'name' => $request->name,
            'description' => $request->description,
            'order' => $order,
        ]);

        return redirect()->back()->with('msg', 'Module added successfully.');
    }

    public function updateModule(Request $request, System $system, Module $module)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'order' => 'nullable|integer|min:0', // Validate order as an integer
        ]);

        $module->update([
            'name' => $request->name,
            'description' => $request->description,
            'order' => $request->order ?? $module->order ?? 0, // Retain existing order if not provided
        ]);

        return redirect()->back()->with('msg', 'Module updated successfully.');
    }

    public function destroyModule($systemId,  $moduleId)
    {

        $system = System::where('id', $systemId)->first();
        $module = Module::where('id', $moduleId)->first();
        // Ensure the module belongs to the system
        if ($module->system_id !== $system->id) {
            return response()->json(['message' => 'Module not found in this system.'], 404);
        }

        // Check if the module has linked submodules or features
        if ($module->submodules()->count() > 0 || $module->features()->count() > 0) {
            return response()->json(['message' => 'Cannot delete module with linked submodules or features.'], 400);
        }

        // Delete the module
        $module->delete();

        return response()->json(['message' => 'Module deleted successfully.']);
    }

    public function storeSubmodule(Request $request, System $system)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'module_id' => 'required|exists:modules,id,system_id,' . $system->id,
        ]);

        Submodule::create([
            'name' => $request->name,
            'description' => $request->description,
            'module_id' => $request->module_id,
        ]);

        return redirect()->route('systems.show', $system)->with('msg', 'Submodule added successfully.');
    }

    public function updateSubmodule(Request $request, System $system, Submodule $submodule)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'module_id' => 'required|exists:modules,id,system_id,' . $system->id,
        ]);

        $submodule->update([
            'name' => $request->name,
            'description' => $request->description,
            'module_id' => $request->module_id,
        ]);

        return redirect()->route('systems.show', $system)->with('msg', 'Submodule updated successfully.');
    }

    public function destroySubmodule(System $system, Submodule $submodule)
    {
        if ($submodule->features()->exists()) {
            return redirect()->route('systems.show', $system)->with('error', 'Cannot delete submodule with linked features.');
        }

        $submodule->delete();
        return redirect()->route('systems.show', $system)->with('msg', 'Submodule deleted successfully.');
    }

    public function exportFeaturesExcel(System $system)
    {
        return Excel::download(new FeaturesExport($system), 'system_' . $system->id . '_features.xlsx');
    }

    public function exportRequirementsExcel(System $system)
    {
        return Excel::download(new RequirementsExport($system), 'system_' . $system->id . '_requirements.xlsx');
    }

    public function exportFeaturesPdf(System $system)
    {
        $pdf = FacadePdf::loadView('systems.export_features_pdf', compact('system'));
        return $pdf->download('system_' . $system->id . '_features.pdf');
    }

    public function exportRequirementsPdf(System $system)
    {
        $pdf = FacadePdf::loadView('systems.export_requirements_pdf', compact('system'));
        return $pdf->download('system_' . $system->id . '_requirements.pdf');
    }
}
