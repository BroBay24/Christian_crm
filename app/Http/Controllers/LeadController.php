<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LeadController extends Controller
{
    /**
     * Display a listing of the resource.
     * Menampilkan lead sesuai role
     */
    public function index()
    {
        // Sales dan Manager bisa melihat semua lead untuk monitoring
        $leads = Lead::with('creator')
            ->latest()
            ->paginate(10);

        return view('leads.index', compact('leads'));
    }

    /**
     * Show the form for creating a new resource.
     * Tampilkan form tambah lead
     */
    public function create()
    {
        return view('leads.create');
    }

    /**
     * Store a newly created resource in storage.
     * Simpan lead baru
     */
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'company' => 'nullable|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255|unique:leads,email',
        ], [
            'name.required' => 'Nama harus diisi',
            'phone.required' => 'Telepon harus diisi',
            'email.required' => 'Email harus diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
        ]);

        // Tambahkan created_by otomatis dari user login
        $validated['created_by'] = Auth::id();
        $validated['status'] = 'new'; // Status default

        Lead::create($validated);

        return redirect()
            ->route('leads.index')
            ->with('success', 'Lead berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Lead $lead)
    {
        // Opsional: untuk detail lead
        $this->authorize('view', $lead);
        
        return view('leads.show', compact('lead'));
    }

    /**
     * Show the form for editing the specified resource.
     * Tampilkan form edit lead
     */
    public function edit(Lead $lead)
    {
        $user = Auth::user();

        // Sales hanya bisa edit lead yang dia buat
        if ($user->isSales() && $lead->created_by !== $user->id) {
            abort(403, 'Anda tidak memiliki akses untuk mengedit lead ini.');
        }

        return view('leads.edit', compact('lead'));
    }

    /**
     * Update the specified resource in storage.
     * Update lead
     */
    public function update(Request $request, Lead $lead)
    {
        $user = Auth::user();

        // Sales hanya bisa edit lead yang dia buat
        if ($user->isSales() && $lead->created_by !== $user->id) {
            abort(403, 'Anda tidak memiliki akses untuk mengupdate lead ini.');
        }

        // Validasi input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'company' => 'nullable|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255|unique:leads,email,' . $lead->id,
        ], [
            'name.required' => 'Nama harus diisi',
            'phone.required' => 'Telepon harus diisi',
            'email.required' => 'Email harus diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
        ]);

        // Manager bisa update status
        if ($user->isManager() && $request->has('status')) {
            $validated['status'] = $request->status;
        }

        $lead->update($validated);

        return redirect()
            ->route('leads.index')
            ->with('success', 'Lead berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     * Hapus lead (hanya manager)
     */
    public function destroy(Lead $lead)
    {
        $user = Auth::user();

        // Hanya manager yang boleh hapus
        if (!$user->isManager()) {
            abort(403, 'Hanya Manager yang dapat menghapus lead.');
        }

        $lead->delete();

        return redirect()
            ->route('leads.index')
            ->with('success', 'Lead berhasil dihapus!');
    }

    /**
     * Approve lead (khusus manager)
     */
    public function approve(Lead $lead)
    {
        $user = Auth::user();

        if (!$user->isManager()) {
            abort(403, 'Hanya Manager yang dapat approve lead.');
        }

        $lead->update(['status' => 'approved']);

        return redirect()
            ->route('leads.index')
            ->with('success', 'Lead berhasil di-approve!');
    }

    /**
     * Reject lead (khusus manager)
     */
    public function reject(Lead $lead)
    {
        $user = Auth::user();

        if (!$user->isManager()) {
            abort(403, 'Hanya Manager yang dapat reject lead.');
        }

        $lead->update(['status' => 'rejected']);

        return redirect()
            ->route('leads.index')
            ->with('success', 'Lead berhasil di-reject!');
    }
}
