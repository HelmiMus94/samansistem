<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Violations') }}
            </h2>
            <a href="{{ route('violations.create') }}" class="btn btn-primary">Create New Violation</a>
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
                        <form action="{{ route('violations.index') }}" method="GET">
                            <input type="text" placeholder="Search by code or description"
                                class="input input-bordered w-full max-w-md" name="search"
                                value="{{ request('search') }}" />
                        </form>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="table table-zebra w-full">
                            <thead>
                                <tr>
                                    <th>Code</th>
                                    <th>Description</th>
                                    <th>Penalty Amount</th>
                                    <th>Demerit Points</th>
                                    <th>Category</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($violations as $violation)
                                    <tr>
                                        <td>{{ $violation->code }}</td>
                                        <td>{{ $violation->description }}</td>
                                        <td>RM {{ number_format($violation->penalty_amount, 2) }}</td>
                                        <td>{{ $violation->demerit_points }}</td>
                                        <td>{{ $violation->category }}</td>
                                        <td>
                                            <div class="flex space-x-2">
                                                <a href="{{ route('violations.show', $violation) }}"
                                                    class="btn btn-info btn-sm">View</a>
                                                <a href="{{ route('violations.edit', $violation) }}"
                                                    class="btn btn-warning btn-sm">Edit</a>
                                                <form action="{{ route('violations.destroy', $violation) }}" method="POST"
                                                    onsubmit="return confirm('Are you sure you want to delete this violation?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-error btn-sm">Delete</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{ $violations->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>