<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Payments Report') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('reports.payments') }}" method="GET" class="mb-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="date_from" :value="__('Date From')" />
                                <x-text-input id="date_from" class="block mt-1 w-full" type="date" name="date_from"
                                    :value="request('date_from')" />
                            </div>
                            <div>
                                <x-input-label for="date_to" :value="__('Date To')" />
                                <x-text-input id="date_to" class="block mt-1 w-full" type="date" name="date_to"
                                    :value="request('date_to')" />
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary mt-4">Generate Report</button>
                    </form>

                    <div class="mb-4">
                        Total Amount: RM {{ number_format($totalAmount, 2) }}
                    </div>

                    <div class="overflow-x-auto">
                        <table class="table table-zebra w-full">
                            <thead>
                                <tr>
                                    <th>Receipt #</th>
                                    <th>Customer</th>
                                    <th>Date</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($payments as $payment)
                                    <tr>
                                        <td>{{ $payment->receipt_number }}</td>
                                        <td>{{ $payment->summon->rental->customer->name ?? 'N/A' }}</td>
                                        <td>{{ $payment->payment_datetime->format('d/m/Y H:i') }}</td>
                                        <td>RM {{ number_format($payment->amount_paid, 2) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-4">No payment records found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>