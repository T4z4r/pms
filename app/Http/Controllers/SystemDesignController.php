<?php
namespace App\Http\Controllers;

use App\Models\SystemDesign;
use App\Models\System;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class SystemDesignController extends Controller
{
    public function index()
    {
        $designs = SystemDesign::with('system', 'creator', 'updater')
            ->whereIn('system_id', System::where('created_by', Auth::id())
                ->orWhere('assigned_to', Auth::id())
                ->orWhere('is_all_users', true)
                ->pluck('id'))
            ->get();
        $systems = System::where('created_by', Auth::id())
            ->orWhere('assigned_to', Auth::id())
            ->orWhere('is_all_users', true)
            ->get();
        return view('system-designs.index', compact('designs', 'systems'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'type' => 'required|in:erd,class_diagram,flowchart',
                'image' => 'required|image|mimes:png|max:2048', // PNG, max 2MB
                'system_id' => 'required|exists:systems,id',
            ]);

            $image = $request->file('image');
            $imagePath = 'designs/' . Str::uuid() . '.png';
            Storage::disk('public')->put($imagePath, file_get_contents($image));

            $thumbnailPath = null;
            if ($image) {
                $thumbnail = \Intervention\Image\Facades\Image::make($image)->fit(100, 100)->encode('png');
                $thumbnailPath = 'thumbnails/' . Str::uuid() . '.png';
                Storage::disk('public')->put($thumbnailPath, $thumbnail);
            }

            $design = SystemDesign::create([
                'system_id' => $request->system_id,
                'title' => $request->title,
                'type' => $request->type,
                'image_path' => $imagePath,
                'thumbnail_path' => $thumbnailPath,
                'created_by' => Auth::id(),
                'updated_by' => Auth::id(),
            ]);

            return redirect()->route('system-designs.index')->with('msg', 'Design created successfully.');
        } catch (\Exception $e) {
            Log::error('Failed to save design: ' . $e->getMessage(), ['request' => $request->all()]);
            return redirect()->back()->withErrors(['image' => 'Failed to save design: ' . $e->getMessage()]);
        }
    }

    public function update(Request $request, SystemDesign $systemDesign)
    {
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'type' => 'required|in:erd,class_diagram,flowchart',
                'image' => 'nullable|image|mimes:png|max:2048',
                'system_id' => 'required|exists:systems,id',
            ]);

            $imagePath = $systemDesign->image_path;
            $thumbnailPath = $systemDesign->thumbnail_path;

            if ($request->hasFile('image')) {
                if ($imagePath) {
                    Storage::disk('public')->delete($imagePath);
                }
                if ($thumbnailPath) {
                    Storage::disk('public')->delete($thumbnailPath);
                }
                $image = $request->file('image');
                $imagePath = 'designs/' . Str::uuid() . '.png';
                Storage::disk('public')->put($imagePath, file_get_contents($image));

                $thumbnail = \Intervention\Image\Facades\Image::make($image)->fit(100, 100)->encode('png');
                $thumbnailPath = 'thumbnails/' . Str::uuid() . '.png';
                Storage::disk('public')->put($thumbnailPath, $thumbnail);
            }

            $systemDesign->update([
                'system_id' => $request->system_id,
                'title' => $request->title,
                'type' => $request->type,
                'image_path' => $imagePath,
                'thumbnail_path' => $thumbnailPath,
                'updated_by' => Auth::id(),
            ]);

            return response()->json(['success' => 'Design updated successfully.']);
        } catch (\Exception $e) {
            Log::error('Failed to update design: ' . $e->getMessage(), ['request' => $request->all(), 'design_id' => $systemDesign->id]);
            return response()->json(['error' => 'Failed to update design: ' . $e->getMessage()], 500);
        }
    }

    public function destroy(SystemDesign $systemDesign)
    {
        try {
            if ($systemDesign->image_path) {
                Storage::disk('public')->delete($systemDesign->image_path);
            }
            if ($systemDesign->thumbnail_path) {
                Storage::disk('public')->delete($systemDesign->thumbnail_path);
            }
            $systemDesign->delete();
            return response()->json(['success' => 'Design deleted successfully.']);
        } catch (\Exception $e) {
            Log::error('Failed to delete design: ' . $e->getMessage(), ['design_id' => $systemDesign->id]);
            return response()->json(['error' => 'Failed to delete design: ' . $e->getMessage()], 500);
        }
    }
}