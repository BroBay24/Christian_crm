<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        
        if (!$user->isManager()) {
            abort(403, 'Unauthorized action.');
        }

        $projects = Project::with(['lead', 'approvedBy'])
            ->latest()
            ->paginate(10);

        return view('projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();
        
        if (!$user->isManager()) {
            abort(403, 'Unauthorized action.');
        }

        // Only show approved leads that don't have projects yet
        $leads = Lead::where('status', 'approved')
            ->whereDoesntHave('project')
            ->get();

        return view('projects.create', compact('leads'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        
        if (!$user->isManager()) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'lead_id' => 'required|exists:leads,id',
        ]);

        // Check if lead is approved
        $lead = Lead::findOrFail($validated['lead_id']);
        if ($lead->status !== 'approved') {
            return back()->withErrors(['lead_id' => 'Only approved leads can be converted to projects.']);
        }

        // Check if project already exists for this lead
        if ($lead->project) {
            return back()->withErrors(['lead_id' => 'This lead already has a project.']);
        }

        Project::create([
            'lead_id' => $validated['lead_id'],
            'status' => 'pending',
        ]);

        return redirect()->route('projects.index')
            ->with('success', 'Project created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = Auth::user();
        
        if (!$user->isManager()) {
            abort(403, 'Unauthorized action.');
        }

        $project = Project::with('lead')->findOrFail($id);

        return view('projects.edit', compact('project'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = Auth::user();
        
        if (!$user->isManager()) {
            abort(403, 'Unauthorized action.');
        }

        $project = Project::findOrFail($id);

        $validated = $request->validate([
            'status' => 'required|in:pending,approved,rejected',
        ]);

        $project->update($validated);

        return redirect()->route('projects.index')
            ->with('success', 'Project updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = Auth::user();
        
        if (!$user->isManager()) {
            abort(403, 'Unauthorized action.');
        }

        $project = Project::findOrFail($id);
        $project->delete();

        return redirect()->route('projects.index')
            ->with('success', 'Project deleted successfully.');
    }

    /**
     * Approve a project and convert to customer.
     */
    public function approve(string $id)
    {
        $user = Auth::user();
        
        if (!$user->isManager()) {
            abort(403, 'Unauthorized action.');
        }

        $project = Project::with('lead')->findOrFail($id);
        
        if ($project->status === 'approved') {
            return back()->withErrors(['status' => 'Project is already approved.']);
        }

        $project->update([
            'status' => 'approved',
            'approved_by' => $user->id,
            'approved_date' => now(),
        ]);

        return redirect()->route('projects.index')
            ->with('success', 'Project approved successfully.');
    }

    /**
     * Reject a project.
     */
    public function reject(string $id)
    {
        $user = Auth::user();
        
        if (!$user->isManager()) {
            abort(403, 'Unauthorized action.');
        }

        $project = Project::findOrFail($id);

        $project->update([
            'status' => 'rejected',
            'approved_by' => $user->id,
            'approved_date' => now(),
        ]);

        return redirect()->route('projects.index')
            ->with('success', 'Project rejected successfully.');
    }
}
