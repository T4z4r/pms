<?php
namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\System;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::with('creator', 'updater', 'projects')->get();
        $totalClients = $clients->count();
        $clientsWithProjects = $clients->filter(fn($client) => $client->projects->count() > 0)->count();

        return view('clients.index', compact('clients', 'totalClients', 'clientsWithProjects'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:clients,email',
                'phone' => 'nullable|string|max:20',
                'address' => 'nullable|string',
            ]);

            $client = Client::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'created_by' => Auth::id(),
                'updated_by' => Auth::id(),
            ]);

            return redirect()->route('clients.index')->with('msg', 'Client created successfully.');
        } catch (\Exception $e) {
            Log::error('Failed to save client: ' . $e->getMessage(), ['request' => $request->all()]);
            return redirect()->back()->withErrors(['email' => 'Failed to save client: ' . $e->getMessage()]);
        }
    }

    public function update(Request $request, Client $client)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:clients,email,' . $client->id,
                'phone' => 'nullable|string|max:20',
                'address' => 'nullable|string',
            ]);

            $client->update([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'updated_by' => Auth::id(),
            ]);

            return response()->json(['success' => 'Client updated successfully.']);
        } catch (\Exception $e) {
            Log::error('Failed to update client: ' . $e->getMessage(), ['request' => $request->all(), 'client_id' => $client->id]);
            return response()->json(['error' => 'Failed to update client: ' . $e->getMessage()], 500);
        }
    }

    public function destroy(Client $client)
    {
        try {
            $client->delete();
            return response()->json(['success' => 'Client deleted successfully.']);
        } catch (\Exception $e) {
            Log::error('Failed to delete client: ' . $e->getMessage(), ['client_id' => $client->id]);
            return response()->json(['error' => 'Failed to delete client: ' . $e->getMessage()], 500);
        }
    }
}
