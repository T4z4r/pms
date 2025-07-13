<?php

namespace App\Http\Controllers;

use App\Models\System;
use App\Models\Standard;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;

class StandardController extends Controller
{
    public function index()
    {
        $standards = Standard::with('creator', 'updater')
            // ->whereIn('system_id', System::where('created_by', Auth::id())
            //     ->orWhere('assigned_to', Auth::id())
            //     ->orWhere('is_all_users', true)
            //     ->pluck('id'))
            ->get();
        $systems = System::where('created_by', Auth::id())
            ->orWhere('assigned_to', Auth::id())
            ->orWhere('is_all_users', true)
            ->get();
        $totalStandards = $standards->count();
        $complianceCounts = [
            'compliant' => $standards->where('compliance_status', 'compliant')->count(),
            'non_compliant' => $standards->where('compliance_status', 'non_compliant')->count(),
            'partially_compliant' => $standards->where('compliance_status', 'partially_compliant')->count(),
            'not_applicable' => $standards->where('compliance_status', 'not_applicable')->count(),
        ];

        return view('standards.index', compact('standards', 'systems', 'totalStandards', 'complianceCounts'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'compliance_status' => 'required|in:compliant,non_compliant,partially_compliant,not_applicable',
                // 'system_id' => 'required|exists:systems,id',
            ]);

            $standard = Standard::create([
                // 'system_id' => $request->system_id,
                'name' => $request->name,
                'description' => $request->description,
                'compliance_status' => $request->compliance_status,
                'created_by' => Auth::id(),
                'updated_by' => Auth::id(),
            ]);

            return redirect()->route('standards.index')->with('msg', 'Standard created successfully.');
        } catch (\Exception $e) {
            Log::error('Failed to save standard: ' . $e->getMessage(), ['request' => $request->all()]);
            return redirect()->back()->withErrors(['name' => 'Failed to save standard: ' . $e->getMessage()]);
        }
    }

    public function update(Request $request, Standard $standard)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'compliance_status' => 'required|in:compliant,non_compliant,partially_compliant,not_applicable',
                // 'system_id' => 'required|exists:systems,id',
            ]);

            $standard->update([
                // 'system_id' => $request->system_id,
                'name' => $request->name,
                'description' => $request->description,
                'compliance_status' => $request->compliance_status,
                'updated_by' => Auth::id(),
            ]);

            return response()->json(['success' => 'Standard updated successfully.']);
        } catch (\Exception $e) {
            Log::error('Failed to update standard: ' . $e->getMessage(), ['request' => $request->all(), 'standard_id' => $standard->id]);
            return response()->json(['error' => 'Failed to update standard: ' . $e->getMessage()], 500);
        }
    }

    public function destroy(Standard $standard)
    {
        try {
            $standard->delete();
            return response()->json(['success' => 'Standard deleted successfully.']);
        } catch (\Exception $e) {
            Log::error('Failed to delete standard: ' . $e->getMessage(), ['standard_id' => $standard->id]);
            return response()->json(['error' => 'Failed to delete standard: ' . $e->getMessage()], 500);
        }
    }

    public function download(Standard $standard)
    {
        try {
            $data = [
                'standard' => $standard,
                'creator' => $standard->creator->name,
                'updater' => $standard->updater ? $standard->updater->name : '-',
                'created_at' => $standard->created_at->format('Y-m-d H:i'),
            ];

            $pdf = FacadePdf::loadView('standards.pdf', $data);


            return $pdf->download('standard_' . $standard->id . '.pdf');
        } catch (\Exception $e) {
            Log::error('Failed to download standard: ' . $e->getMessage(), ['standard_id' => $standard->id]);
            return redirect()->back()->withErrors(['download' => 'Failed to download standard: ' . $e->getMessage()]);
        }
    }

    public function downloadAll()
    {
        try {
            $standards = Standard::with('creator', 'updater')
                ->get();

            $data = [
                'standards' => $standards,
            ];

            $pdf = PDF::loadView('standards.pdf_all', $data);
            return $pdf->download('all_standards_' . now()->format('Ymd_His') . '.pdf');
        } catch (\Exception $e) {
            Log::error('Failed to download all standards: ' . $e->getMessage());
            return redirect()->back()->withErrors(['download' => 'Failed to download all standards: ' . $e->getMessage()]);
        }
    }
}