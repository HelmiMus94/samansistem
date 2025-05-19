<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Summons Records') }}
            </h2>
            <a href="{{ route('summons.create') }}" class="btn btn-primary">
                Add New Summon
            </a>
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

                    <div class="mb-4">
                        <form action="{{ route('summons.index') }}" method="GET">
                            <input type="text" placeholder="Search by summon number, customer, or vehicle"
                                class="input input-bordered w-full max-w-md" name="search"
                                value="{{ request('search') }}" />
                        </form>
                    </div>

                    @if(session('error'))
                        <div class="alert alert-error mb-4">
                            {{ session('error') }}
                        </div>
                    @endif

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
                                    <th>Actions</th>
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
                                        <td>
                                            <div class="flex space-x-2">
                                                <a href="{{ route('summons.show', $summon) }}"
                                                    class="btn btn-sm btn-info">View</a>
                                                <a href="{{ route('summons.edit', $summon) }}"
                                                    class="btn btn-sm btn-warning">Edit</a>
                                                <form action="{{ route('summons.destroy', $summon) }}" method="POST"
                                                    onsubmit="return confirm('Are you sure you want to delete this summon?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-error">Delete</button>
                                                </form>
                                            </div>
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

                    <div class="mt-4">
                        {{ $summons->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>