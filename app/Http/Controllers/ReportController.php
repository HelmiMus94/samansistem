<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Summon;
use App\Models\Payment;

class ReportController extends Controller
{
    public function summons(Request $request)
    {
        // Filter summons based on request parameters
        $query = Summon::with(['rental.customer', 'rental.vehicle', 'violation', 'status']);

        // Apply filters if they exist in the request
        if ($request->has('date_from')) {
            $query->where('issue_datetime', '>=', $request->date_from);
        }

        if ($request->has('date_to')) {
            $query->where('issue_datetime', '<=', $request->date_to);
        }

        if ($request->has('status_id')) {
            $query->where('status_id', $request->status_id);
        }

        $summons = $query->latest()->paginate(15);

        return view('reports.summons', compact('summons'));
    }

    public function payments(Request $request)
    {
        // Filter payments based on request parameters
        $query = Payment::with(['summon.rental.customer']);

        // Apply filters if they exist in the request
        if ($request->has('date_from')) {
            $query->where('payment_datetime', '>=', $request->date_from);
        }

        if ($request->has('date_to')) {
            $query->where('payment_datetime', '<=', $request->date_to);
        }

        $payments = $query->latest()->paginate(15);
        $totalAmount = $payments->sum('amount_paid');

        return view('reports.payments', compact('payments', 'totalAmount'));
    }
}