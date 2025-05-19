<?php

namespace App\Http\Controllers;

use App\Models\Violation;
use Illuminate\Http\Request;

class ViolationController extends Controller
{
    /**
     * Display a listing of the violations.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $violations = Violation::when($search, function ($query, $search) {
            $query->where('code', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%");
        })
            ->latest()
            ->paginate(10);
        return view('violations.index', compact('violations'));
    }

    /**
     * Show the form for creating a new violation.
     */
    public function create()
    {
        return view('violations.create');
    }

    /**
     * Store a newly created violation in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|max:255|unique:violations',
            'description' => 'required|string',
            'penalty_amount' => 'required|numeric|min:0',
            'demerit_points' => 'required|integer|min:0',
            'category' => 'nullable|string|max:255',
        ]);

        Violation::create($request->all());

        return redirect()->route('violations.index')
            ->with('success', 'Violation created successfully.');
    }

    /**
     * Display the specified violation.
     */
    public function show(Violation $violation)
    {
        return view('violations.show', compact('violation'));
    }

    /**
     * Show the form for editing the specified violation.
     */
    public function edit(Violation $violation)
    {
        return view('violations.edit', compact('violation'));
    }

    /**
     * Update the specified violation in storage.
     */
    public function update(Request $request, Violation $violation)
    {
        $request->validate([
            'code' => 'required|string|max:255|unique:violations,code,' . $violation->id,
            'description' => 'required|string',
            'penalty_amount' => 'required|numeric|min:0',
            'demerit_points' => 'required|integer|min:0',
            'category' => 'nullable|string|max:255',
        ]);

        $violation->update($request->all());

        return redirect()->route('violations.index')
            ->with('success', 'Violation updated successfully.');
    }

    /**
     * Remove the specified violation from storage.
     */
    public function destroy(Violation $violation)
    {
        // Check if violation has any summons before deleting
        if ($violation->summons()->exists()) {
            return redirect()->route('violations.index')
                ->with('error', 'Cannot delete violation with existing summons.');
        }

        $violation->delete();

        return redirect()->route('violations.index')
            ->with('success', 'Violation deleted successfully.');
    }
}
