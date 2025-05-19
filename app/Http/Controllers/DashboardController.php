<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Summon;
use App\Models\Customer;
use App\Models\Payment;

class DashboardController extends Controller
{
    public function index()
    {
        // Get summary data for dashboard
        $totalSummons = Summon::count();
        $totalCustomers = Customer::count();
        $totalPayments = Payment::sum('amount_paid');
        $pendingSummons = Summon::where('status_id', 1)->count(); // Assuming status_id 1 is 'Pending'

        // Get recent summons
        $recentSummons = Summon::with(['rental.customer', 'violation', 'status'])
            ->latest()
            ->take(5)
            ->get();

        // Get recent payments
        $recentPayments = Payment::with('summon')
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalSummons',
            'totalCustomers',
            'totalPayments',
            'pendingSummons',
            'recentSummons',
            'recentPayments'
        ));
    }
}