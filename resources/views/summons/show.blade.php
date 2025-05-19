<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Summon Details') }}: {{ $summon->summons_number }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('summons.edit', $summon) }}" class="btn btn-warning">Edit</a>
                <a href="{{ route('summons.index') }}" class="btn btn-primary">Back to List</a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if(session('success'))
                        <div class="alert alert-success mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Summon Details -->
                        <div class="card bg-base-100 shadow-xl">
                            <div class="card-body">
                                <h2 class="card-title">Summon Information</h2>
                                <div class="grid grid-cols-2 gap-4 mt-4">
                                    <div class="font-semibold">Summons Number:</div>
                                    <div>{{ $summon->summons_number }}</div>
                                    
                                    <div class="font-semibold">Issue Date/Time:</div>
                                    <div>{{ $summon->issue_datetime->format('d/m/Y H:i') }}</div>
                                    
                                    <div class="font-semibold">Violation:</div>
                                    <div>{{ $summon->violation->description }}</div>
                                    
                                    <div class="font-semibold">Location:</div>
                                    <div>{{ $summon->location }}</div>
                                    
                                    <div class="font-semibold">Amount:</div>
                                    <div>RM {{ number_format($summon->total_amount, 2) }}</div>
                                    
                                    <div class="font-semibold">Due Date:</div>
                                    <div>{{ $summon->due_date->format('d/m/Y') }}</div>
                                    
                                    <div class="font-semibold">Status:</div>
                                    <div>
                                        <span class="badge {{ $summon->status->name == 'Paid' ? 'badge-success' : ($summon->isOverdue() ? 'badge-error' : 'badge-warning') }}">
                                            {{ $summon->status->name }}
                                        </span>
                                    </div>
                                    
                                    <div class="font-semibold">Officer Name:</div>
                                    <div>{{ $summon->officer_name }}</div>
                                    
                                    <div class="font-semibold">Badge Number:</div>
                                    <div>{{ $summon->officer_badge_number }}</div>
                                    
                                    <div class="font-semibold">Comments:</div>
                                    <div>{{ $summon->comments ?? 'None' }}</div>
                                </div>
                            </div>
                        </div>

                        <!-- Customer & Vehicle -->
                        <div class="card bg-base-100 shadow-xl">
                            <div class="card-body">
                                <h2 class="card-title">Customer & Vehicle Information</h2>
                                <div class="grid grid-cols-2 gap-4 mt-4">
                                    <div class="font-semibold">Customer:</div>
                                    <div>{{ $summon->rental->customer->name }}</div>
                                    
                                    <div class="font-semibold">ID Number:</div>
                                    <div>{{ $summon->rental->customer->id_number }}</div>
                                    
                                    <div class="font-semibold">Phone:</div>
                                    <div>{{ $summon->rental->customer->phone }}</div>
                                    
                                    <div class="font-semibold">Vehicle:</div>
                                    <div>{{ $summon->rental->vehicle->registration_number }}</div>
                                    
                                    <div class="font-semibold">Make/Model:</div>
                                    <div>{{ $summon->rental->vehicle->make }} {{ $summon->rental->vehicle->model }}</div>
                                    
                                    <div class="font-semibold">Rental Period:</div>
                                    <div>
                                        {{ $summon->rental->start_date->format('d/m/Y') }} - 
                                        {{ $summon->rental->end_date->format('d/m/Y') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Information -->
                    <div class="mt-6">
                        <h3 class="text-lg font-semibold mb-2">Payment Information</h3>
                        
                        <div class="mb-4">
                            <div class="font-semibold">Total Amount: RM {{ number_format($summon->total_amount, 2) }}</div>
                            <div class="font-semibold">Amount Paid: RM {{ number_format($summon->total_paid, 2) }}</div>
                            <div class="font-semibold">Balance: RM {{ number_format($summon->remaining_balance, 2) }}</div>
                        </div>
                        
                        @if($summon->payments->count() > 0)
                            <div class="overflow-x-auto">
                                <table class="table w-full">
                                    <thead>
                                        <tr>
                                            <th>Receipt #</th>
                                            <th>Date</th>
                                            <th>Amount</th>
                                            <th>Method</th>
                                            <th>Processed By</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($summon->payments as $payment)
                                            <tr>
                                                <td>{{ $payment->receipt_number }}</td>
                                                <td>{{ $payment->payment_datetime->format('d/m/Y H:i') }}</td>
                                                <td>RM {{ number_format($payment->amount_paid, 2) }}</td>
                                                <td>{{ $payment->payment_method }}</td>
                                                <td>{{ $payment->processed_by }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="alert alert-info">No payment records found.</div>
                        @endif
                    </div>

                    <!-- Evidence Image (if available) -->
                    @if($summon->photo_evidence)
                        <div class="mt-6">
                            <h3 class="text-lg font-semibold mb-2">Evidence Photo</h3>
                            <img src="{{ asset('storage/' . $summon->photo_evidence) }}" 
                                alt="Evidence Photo" 
                                class="max-w-md rounded-lg shadow-lg">
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>