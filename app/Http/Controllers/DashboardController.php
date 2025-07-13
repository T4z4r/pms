<?php
namespace App\Http\Controllers;

use App\Models\System;
use App\Models\Project;
use App\Models\Feature;
use App\Models\Requirement;
use App\Models\TestPlan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Statistics
        $totalSystems = System::where('created_by', Auth::id())
            ->orWhere('assigned_to', Auth::id())
            ->orWhere('is_all_users', true)
            ->count();
        $totalProjects = Project::where('created_by', Auth::id())
            // ->orWhere('assigned_to', Auth::id())
            // ->orWhere('is_all_users', true)
            ->count();
        $totalFeatures = Feature::whereIn('system_id', System::where('created_by', Auth::id())
            ->orWhere('assigned_to', Auth::id())
            ->orWhere('is_all_users', true)
            ->pluck('id'))
            ->count();
        $totalRequirements = Requirement::whereIn('system_id', System::where('created_by', Auth::id())
            ->orWhere('assigned_to', Auth::id())
            ->orWhere('is_all_users', true)
            ->pluck('id'))
            ->count();

        // Chart Data
        $systemStatusCounts = System::where('created_by', Auth::id())
            ->orWhere('assigned_to', Auth::id())
            ->orWhere('is_all_users', true)
            ->groupBy('status')
            ->selectRaw('status, count(*) as count')
            ->pluck('count', 'status')
            ->toArray();
        $projectStatusCounts = Project::where('created_by', Auth::id())
            // ->orWhere('assigned_to', Auth::id())
            // ->orWhere('is_all_users', true)
            ->groupBy('status')
            ->selectRaw('status, count(*) as count')
            ->pluck('count', 'status')
            ->toArray();

        // Recent Items for Tables
        $recentSystems = System::with('projects', 'creator', 'assignee')
            ->where('created_by', Auth::id())
            ->orWhere('assigned_to', Auth::id())
            ->orWhere('is_all_users', true)
            ->latest()
            ->take(5)
            ->get();
        $recentProjects = Project::with('creator', 'assignee')
            ->where('created_by', Auth::id())
            // ->orWhere('assigned_to', Auth::id())
            // ->orWhere('is_all_users', true)
            ->latest()
            ->take(5)
            ->get();

        // Timeline Data (Project Milestones)
        $timelineEvents = Project::where('created_by', Auth::id())
            // ->orWhere('assigned_to', Auth::id())
            // ->orWhere('is_all_users', true)
            // ->whereNotNull('start_date')
            ->get()
            ->map(function ($project) {
                return [
                    'title' => $project->name,
                    'date' => $project->created_at->format('Y-m-d'),
                    'description' => 'Project Start: ' . $project->name,
                    'status' => $project->status,
                ];
            })->toArray();

        // Calendar Data (Test Plans)
        $calendarEvents = TestPlan::where('created_by', Auth::id())
            ->orWhere('assigned_to', Auth::id())
            ->get()
            ->map(function ($testPlan) {
                return [
                    'title' => $testPlan->title,
                    'start' => $testPlan->start_date->format('Y-m-d\TH:i:s'),
                    'end' => $testPlan->end_date ? $testPlan->end_date->format('Y-m-d\TH:i:s') : null,
                    'color' => $testPlan->color,
                ];
            })->toArray();

        return view('dashboard', compact(
            'totalSystems',
            'totalProjects',
            'totalFeatures',
            'totalRequirements',
            'systemStatusCounts',
            'projectStatusCounts',
            'recentSystems',
            'recentProjects',
            'timelineEvents',
            'calendarEvents'
        ));
    }
}