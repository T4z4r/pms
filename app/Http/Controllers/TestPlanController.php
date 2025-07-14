<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Feature;
use App\Models\Project;
use App\Models\TestCase;
use App\Models\TestPlan;
use Illuminate\Http\Request;
use App\Exports\TestCaseExport;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;

class TestPlanController extends Controller
{
    public function index()
    {
        $testPlans = TestPlan::with('testCases')->where('created_by', Auth::id())
            ->orWhere('assigned_to', Auth::id())
            ->get();
        $users = User::all();
        $projects = Project::all();
        return view('test_plans.index', compact('testPlans', 'users', 'projects'));
    }

    public function show(TestPlan $testPlan)
    {
        $testPlan->load('testCases', 'project', 'creator', 'assignee');
        $features = Feature::whereIn('system_id', $testPlan->project->systems->pluck('system_id'))->get();
        return view('test_plans.view', compact('testPlan', 'features'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'project_id' => 'required|exists:projects,id',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'color' => 'required|string',
        ]);

        TestPlan::create([
            'title' => $request->title,
            'description' => $request->description,
            'project_id' => $request->project_id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'color' => $request->color,
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('tests.index')->with('msg', 'Test Plan created successfully.');
    }

    public function update(Request $request, TestPlan $testPlan)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'project_id' => 'required|exists:projects,id',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'color' => 'required|string',
        ]);

        $testPlan->update([
            'title' => $request->title,
            'description' => $request->description,
            'project_id' => $request->project_id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'color' => $request->color,
        ]);

        return response()->json(['success' => 'Test Plan updated successfully.']);
    }

    public function destroy(TestPlan $testPlan)
    {
        $testPlan->delete();
        return response()->json(['success' => 'Test Plan deleted successfully.']);
    }

    public function storeForUser(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'project_id' => 'required|exists:projects,id',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'color' => 'required|string',
            'assigned_to' => 'required|exists:users,id',
        ]);

        TestPlan::create([
            'title' => $request->title,
            'description' => $request->description,
            'project_id' => $request->project_id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'color' => $request->color,
            'created_by' => Auth::id(),
            'assigned_to' => $request->assigned_to,
        ]);

        return redirect()->route('tests.index')->with('msg', 'Test Plan assigned successfully.');
    }

    public function storeTestCase(Request $request, TestPlan $testPlan)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'expected_outcome' => 'nullable|string',
            'status' => 'required|in:pending,passed,failed',
            'feature_id' => 'nullable|exists:features,id', // Validate feature_id
        ]);

        TestCase::create([
            'test_plan_id' => $testPlan->id,
            'title' => $request->title,
            'description' => $request->description,
            'expected_outcome' => $request->expected_outcome,
            'status' => $request->status,
            'created_by' => Auth::id(),
            'feature_id' => $request->feature_id, // Save feature_id
        ]);

        return redirect()->route('tests.show', $testPlan)->with('msg', 'Test Case created successfully.');
    }

    public function updateTestCase(Request $request, TestCase $testCase)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'expected_outcome' => 'nullable|string',
            'status' => 'required|in:pending,passed,failed',
            'feature_id' => 'nullable|exists:features,id', // Validate feature_id
        ]);

        $testCase->update([
            'title' => $request->title,
            'description' => $request->description,
            'expected_outcome' => $request->expected_outcome,
            'status' => $request->status,
            'feature_id' => $request->feature_id, // Update feature_id
        ]);

        return response()->json(['success' => 'Test Case updated successfully.']);
    }

    public function destroyTestCase(TestCase $testCase)
    {
        $testCase->delete();
        return response()->json(['success' => 'Test Case deleted successfully.']);
    }

    public function exportExcel(TestPlan $testPlan)
    {
        return Excel::download(new TestCaseExport($testPlan->id), 'test_plan_' . $testPlan->id . '_test_cases.xlsx');
    }

    public function exportPdf(TestPlan $testPlan)
    {
        $testPlan->load('testCases', 'project', 'creator', 'assignee');
        $pdf = FacadePdf::loadView('test_plans.pdf', compact('testPlan'));
        return $pdf->download('test_plan_' . $testPlan->id . '_test_cases.pdf');
    }
}
