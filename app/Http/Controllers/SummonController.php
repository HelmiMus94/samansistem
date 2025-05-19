<?php

namespace App\Http\Controllers;

use App\Models\Summon;
use App\Models\Customer;
use App\Models\Violation;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SummonController extends Controller
{
    /**
     * Display a listing of the summons.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $summons = Summon::with(['rental.customer', 'violation', 'status'])
            ->when($search, function ($query, $search) {
                $query->where('summons_number', 'like', "%{$search}%")
                    ->orWhereHas('rental.customer', function ($query) use ($search) {
                        $query->where('name', 'like', "%{$search}%");
                    })
                    ->orWhereHas('rental.vehicle', function ($query) use ($search) {
                        $query->where('registration_number', 'like', "%{$search}%");
                    });
            })
            ->latest()
            ->paginate(10);

        return view('summons.index', compact('summons'));
    }

    /**
     * Show the form for creating a new summon.
     */
    public function create()
    {
        $customers = Customer::all();
        $violations = Violation::all();
        $statuses = Status::all();
        return view('summons.create', compact('customers', 'violations', 'statuses'));
    }

    /**
     * Store a newly created summon in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'rental_id' => 'required|exists:rentals,id',
            'violation_id' => 'required|exists:violations,id',
            'issue_datetime' => 'required|date',
            'location' => 'required|string|max:255',
            'officer_name' => 'required|string|max:255',
            'officer_badge_number' => 'nullable|string|max:50',
            'total_amount' => 'required|numeric|min:0',
            'status_id' => 'required|exists:statuses,id',
            'due_date' => 'required|date|after:issue_datetime',
            'comments' => 'nullable|string',
            'photo_evidence' => 'nullable|image|max:2048',
        ]);

        $data = $request->all();

        // Handle file upload if present
        if ($request->hasFile('photo_evidence')) {
            $path = $request->file('photo_evidence')->store('evidence', 'public');
            $data['photo_evidence'] = $path;
        }

        // Generate a unique summons number
        $data['summons_number'] = 'SMN-' . date('Ymd') . '-' . rand(1000, 9999);

        // Record who created this summon
        $data['recorded_by_user_id'] = auth()->id();

        Summon::create($data);

        return redirect()->route('summons.index')
            ->with('success', 'Summon record created successfully.');
    }

    /**
     * Display the specified summon.
     */
    public function show(Summon $summon)
    {
        $summon->load(['rental.customer', 'rental.vehicle', 'violation', 'status', 'payments']);
        return view('summons.show', compact('summon'));
    }

    /**
     * Show the form for editing the specified summon.
     */
    public function edit(Summon $summon)
    {
        $customers = Customer::all();
        $violations = Violation::all();
        $statuses = Status::all();
        $summon->load('rental');

        return view('summons.edit', compact('summon', 'customers', 'violations', 'statuses'));
    }

    /**
     * Update the specified summon in storage.
     */
    public function update(Request $request, Summon $summon)
    {
        $request->validate([
            'rental_id' => 'required|exists:rentals,id',
            'violation_id' => 'required|exists:violations,id',
            'issue_datetime' => 'required|date',
            'location' => 'required|string|max:255',
            'officer_name' => 'required|string|max:255',
            'officer_badge_number' => 'nullable|string|max:50',
            'total_amount' => 'required|numeric|min:0',
            'status_id' => 'required|exists:statuses,id',
            'due_date' => 'required|date',
            'comments' => 'nullable|string',
            'photo_evidence' => 'nullable|image|max:2048',
        ]);

        $data = $request->all();

        // Handle file upload if present
        if ($request->hasFile('photo_evidence')) {
            // Remove old file if exists
            if ($summon->photo_evidence) {
                Storage::disk('public')->delete($summon->photo_evidence);
            }

            $path = $request->file('photo_evidence')->store('evidence', 'public');
            $data['photo_evidence'] = $path;
        }

        $summon->update($data);

        return redirect()->route('summons.index')
            ->with('success', 'Summon record updated successfully.');
    }

    /**
     * Remove the specified summon from storage.
     */
    public function destroy(Summon $summon)
    {
        // Check for payments before deleting
        if ($summon->payments()->exists()) {
            return redirect()->route('summons.index')
                ->with('error', 'Cannot delete summon with existing payments.');
        }

        // Delete the photo if exists
        if ($summon->photo_evidence) {
            Storage::disk('public')->delete($summon->photo_evidence);
        }

        $summon->delete();

        return redirect()->route('summons.index')
            ->with('success', 'Summon record deleted successfully.');
    }
}
