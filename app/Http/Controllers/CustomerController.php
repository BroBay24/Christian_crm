<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
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

        $customers = Customer::with('lead')
            ->latest()
            ->paginate(10);

        return view('customers.index', compact('customers'));
    }

    /**
     * Show the form for creating a new resource from approved project.
     */
    public function create()
    {
        $user = Auth::user();
        
        if (!$user->isManager()) {
            abort(403, 'Unauthorized action.');
        }

        // Only show approved projects that don't have customers yet
        $projects = Project::with('lead')
            ->where('status', 'approved')
            ->whereDoesntHave('customer')
            ->get();

        return view('customers.create', compact('projects'));
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
            'project_id' => 'required|exists:projects,id',
            'start_date' => 'required|date',
        ]);

        // Get project and check if it's approved
        $project = Project::with('lead')->findOrFail($validated['project_id']);
        
        if ($project->status !== 'approved') {
            return back()->withErrors(['project_id' => 'Only approved projects can be converted to customers.']);
        }

        // Check if customer already exists for this project's lead
        if (Customer::where('lead_id', $project->lead_id)->exists()) {
            return back()->withErrors(['project_id' => 'This project\'s lead already has a customer.']);
        }

        Customer::create([
            'lead_id' => $project->lead_id,
            'start_date' => $validated['start_date'],
            'status' => 'active',
        ]);

        return redirect()->route('customers.index')
            ->with('success', 'Customer created successfully from project.');
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

        $customer = Customer::with('lead')->findOrFail($id);

        return view('customers.edit', compact('customer'));
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

        $customer = Customer::findOrFail($id);

        $validated = $request->validate([
            'start_date' => 'required|date',
            'status' => 'required|in:active,inactive',
        ]);

        $customer->update($validated);

        return redirect()->route('customers.index')
            ->with('success', 'Customer updated successfully.');
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

        $customer = Customer::findOrFail($id);
        $customer->delete();

        return redirect()->route('customers.index')
            ->with('success', 'Customer deleted successfully.');
    }

    /**
     * Convert approved project directly to customer
     */
    public function convertFromProject(string $projectId)
    {
        $user = Auth::user();
        
        if (!$user->isManager()) {
            abort(403, 'Unauthorized action.');
        }

        $project = Project::with('lead')->findOrFail($projectId);
        
        if ($project->status !== 'approved') {
            return back()->withErrors(['status' => 'Only approved projects can be converted to customers.']);
        }

        // Check if customer already exists
        if (Customer::where('lead_id', $project->lead_id)->exists()) {
            return back()->withErrors(['status' => 'Customer already exists for this project.']);
        }

        Customer::create([
            'lead_id' => $project->lead_id,
            'start_date' => now(),
            'status' => 'active',
        ]);

        return redirect()->route('customers.index')
            ->with('success', 'Project converted to customer successfully.');
    }
}
