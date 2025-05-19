<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Summons Report') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('reports.summons') }}" method="GET" class="mb-4">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
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
                            <div>
                                <x-input-label for="status_id" :value="__('Status')" />
                                <select id="status_id" name="status_id"
                                    class="select select-bordered block mt-1 w-full">
                                    <option value="">All Statuses</option>
                                    @foreach(\App\Models\Status::all() as $status)
                                        <option value="{{ $status->id }}" {{ request('status_id') == $status->id ? 'selected' : '' }}>{{ $status->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary mt-4">Generate Report</button>
                    </form>

                    <div class="overflow-x-auto">
                        <table class="table table-zebra w-full">
                            <thead>
                                <tr>
                                    <th>Summon #</th>
                                    <th>Customer</th>
                                    <th>Vehicle</th>
                                    <th>Violation</th>
                                    <th>Date/Time</th>
                                    <th>Location</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($summons as $summon)
                                    <tr>
                                        <td>{{ $summon->summons_number }}</td>
                                        <td>{{ $summon->rental->customer->name ?? 'N/A' }}</td>
                                        <td>{{ $summon->rental->vehicle->registration_number ?? 'N/A' }}</td>
                                        <td>{{ $summon->violation->description ?? 'N/A' }}</td>
                                        <td>{{ $summon->issue_datetime->format('d/m/Y H:i') }}</td>
                                        <td>{{ $summon->location }}</td>
                                        <td>RM {{ number_format($summon->total_amount, 2) }}</td>
                                        <td>
                                            <span
                                                class="badge {{ $summon->status->name == 'Paid' ? 'badge-success' : ($summon->isOverdue() ? 'badge-error' : 'badge-warning') }}"
                                                title="{{ $summon->status->name == 'Paid' ? 'This summon has been paid' : ($summon->isOverdue() ? 'This summon is overdue' : 'This summon is pending payment') }}">
                                                {{ $summon->status->name }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-4">No summons records found</td>
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