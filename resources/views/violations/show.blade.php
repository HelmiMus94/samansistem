<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Violation Details') }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('violations.edit', $violation) }}" class="btn btn-warning">Edit</a>
                <a href="{{ route('violations.index') }}" class="btn btn-primary">Back to List</a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <div class="mb-4 font-semibold">Code:</div>
                            <div>{{ $violation->code }}</div>
                        </div>

                        <div>
                            <div class="mb-4 font-semibold">Description:</div>
                            <div>{{ $violation->description }}</div>
                        </div>

                        <div>
                            <div class="mb-4 font-semibold">Penalty Amount:</div>
                            <div>RM {{ number_format($violation->penalty_amount, 2) }}</div>
                        </div>

                        <div>
                            <div class="mb-4 font-semibold">Demerit Points:</div>
                            <div>{{ $violation->demerit_points }}</div>
                        </div>

                        <div>
                            <div class="mb-4 font-semibold">Category:</div>
                            <div>{{ $violation->category }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>