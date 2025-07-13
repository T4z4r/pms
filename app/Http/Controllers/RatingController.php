<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    public function index()
    {
        $ratings = Rating::with(['project', 'user'])->get();
        $projects = Project::all();
        return view('ratings.index', compact('ratings', 'projects'));
    }

    public function create()
    {
        $projects = Project::all();
        return view('ratings.create', compact('projects'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'project_id' => 'required|exists:projects,id',
            'rating' => 'required|integer|min:1|max:5',
        ]);
        Rating::create([
            'project_id' => $request->project_id,
            'user_id' => Auth::id(),
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);
        return redirect()->route('ratings.index')->with('success', 'Rating submitted.');
    }

    public function edit(Rating $rating)
    {
        $projects = Project::all();
        return view('ratings.edit', compact('rating', 'projects'));
    }

    public function update(Request $request, Rating $rating)
    {
        $request->validate([
            'project_id' => 'required|exists:projects,id',
            'rating' => 'required|integer|min:1|max:5',
        ]);
        $rating->update($request->all());
        return redirect()->route('ratings.index')->with('success', 'Rating updated.');
    }

    public function destroy(Rating $rating)
    {
        $rating->delete();
        return redirect()->route('ratings.index')->with('success', 'Rating deleted.');
    }
}
