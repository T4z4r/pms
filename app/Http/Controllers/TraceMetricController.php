<?php

namespace App\Http\Controllers;

use App\Models\TraceMetric;
use App\Models\Project;
use Illuminate\Http\Request;

class TraceMetricController extends Controller
{
    public function index()
    {
        $metrics = TraceMetric::with('project')->get();
        $projects = Project::all();
        return view('trace_metrics.index', compact('metrics','projects'));
    }

    public function create()
    {
        $projects = Project::all();
        return view('trace_metrics.create', compact('projects'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'project_id' => 'required|exists:projects,id',
            'metric_name' => 'required|string|max:255',
            'value' => 'required|numeric',
            'recorded_at' => 'required|date',
        ]);
        TraceMetric::create($request->all());
        return redirect()->route('trace_metrics.index')->with('success', 'Metric recorded.');
    }

    public function edit(TraceMetric $traceMetric)
    {
        $projects = Project::all();
        return view('trace_metrics.edit', compact('traceMetric', 'projects'));
    }

    public function update(Request $request, TraceMetric $traceMetric)
    {
        $request->validate([
            'project_id' => 'required|exists:projects,id',
            'metric_name' => 'required|string|max:255',
            'value' => 'required|numeric',
            'recorded_at' => 'required|date',
        ]);
        $traceMetric->update($request->all());
        return redirect()->route('trace_metrics.index')->with('success', 'Metric updated.');
    }

    public function destroy(TraceMetric $traceMetric)
    {
        $traceMetric->delete();
        return redirect()->route('trace_metrics.index')->with('success', 'Metric deleted.');
    }
}
