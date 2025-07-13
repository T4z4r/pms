<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Traits\HasRoles;

class ActivityController extends Controller
{
    public function __construct()
    {
        // Assign 'admin' role to specific users via seeder or manually
        $this->middleware('role:admin')->only(['storeForUser', 'storeForAll']);
    }

    public function index()
    {
        $user = Auth::user();
        $activities = Activity::where(function ($query) use ($user) {
            $query->where('user_id', $user->id) // User's own activities
                  ->orWhere('assigned_to', $user->id) // Activities assigned to user
                  ->orWhere('is_all_users', true); // Activities for all users
        })->get();

        $users = User::all(); // For admin to select users
        return view('activities.index', compact('activities', 'users'));
    }

    public function getActivities(Request $request)
    {
        $user = Auth::user();
        $activities = Activity::where(function ($query) use ($user) {
            $query->where('user_id', $user->id)
                  ->orWhere('assigned_to', $user->id)
                  ->orWhere('is_all_users', true);
        })
        ->whereBetween('start_time', [$request->start, $request->end])
        ->get();

        return response()->json($activities->map(function ($activity) {
            return [
                'id' => $activity->id,
                'title' => $activity->title,
                'start' => $activity->start_time->toIso8601String(),
                'end' => $activity->end_time?->toIso8601String(),
                'color' => $activity->color,
                'extendedProps' => [
                    'description' => $activity->description,
                    'creator' => $activity->creator->name,
                    'assignee' => $activity->assignee ? $activity->assignee->name : ($activity->is_all_users ? 'All Users' : null),
                ],
            ];
        }));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_time' => 'required|date',
            'end_time' => 'nullable|date|after:start_time',
            'color' => 'nullable|string',
        ]);

        $activity = Activity::create([
            'user_id' => Auth::id(),
            'assigned_to' => Auth::id(), // User's own activity
            ...$validated,
        ]);

        return redirect()->route('activities.index')->with('msg', 'Activity created successfully.');
    }

    public function storeForUser(Request $request)
    {
        $validated = $request->validate([
            'assigned_to' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_time' => 'required|date',
            'end_time' => 'nullable|date|after:start_time',
            'color' => 'nullable|string',
        ]);

        $activity = Activity::create([
            'user_id' => Auth::id(), // Admin as creator
            ...$validated,
        ]);

        return redirect()->route('activities.index')->with('msg', 'Activity assigned successfully.');
    }

    public function storeForAll(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_time' => 'required|date',
            'end_time' => 'nullable|date|after:start_time',
            'color' => 'nullable|string',
        ]);

        $activity = Activity::create([
            'user_id' => Auth::id(), // Admin as creator
            'is_all_users' => true,
            ...$validated,
        ]);

        return redirect()->route('activities.index')->with('msg', 'Activity assigned to all users successfully.');
    }

    public function update(Request $request, Activity $activity)
    {
        // $this->authorize('update', $activity);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_time' => 'required|date',
            'end_time' => 'nullable|date|after:start_time',
            'color' => 'nullable|string',
        ]);

        $activity->update($validated);

        return redirect()->route('activities.index')->with('msg', 'Activity updated successfully.');
    }

    public function destroy(Activity $activity)
    {
        $this->authorize('delete', $activity);
        $activity->delete();
        return response()->json(['message' => 'Activity deleted']);
    }
}
