<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add New Customer') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if ($errors->any())
                        <div class="alert alert-error mb-4">
                            <ul class="list-disc pl-5">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('customers.store') }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <label for="name" class="label"><span class="label-text">Name</span></label>
                            <input type="text" name="name" id="name" class="input input-bordered w-full"
                                value="{{ old('name') }}" required>
                        </div>

                        <div class="mb-4">
                            <label for="id_number" class="label"><span class="label-text">ID Number</span></label>
                            <input type="text" name="id_number" id="id_number" class="input input-bordered w-full"
                                value="{{ old('id_number') }}" required>
                        </div>

                        <div class="mb-4">
                            <label for="license_number" class="label"><span class="label-text">License
                                    Number</span></label>
                            <input type="text" name="license_number" id="license_number"
                                class="input input-bordered w-full" value="{{ old('license_number') }}" required>
                        </div>

                        <div class="mb-4">
                            <label for="phone" class="label"><span class="label-text">Phone</span></label>
                            <input type="tel" name="phone" id="phone" class="input input-bordered w-full"
                                value="{{ old('phone') }}">
                        </div>

                        <div class="mb-4">
                            <label for="email" class="label"><span class="label-text">Email</span></label>
                            <input type="email" name="email" id="email" class="input input-bordered w-full"
                                value="{{ old('email') }}">
                        </div>

                        <div class="mb-4">
                            <label for="address" class="label"><span class="label-text">Address</span></label>
                            <textarea name="address" id="address"
                                class="textarea textarea-bordered w-full">{{ old('address') }}</textarea>
                        </div>

                        <div class="mb-4">
                            <label for="date_of_birth" class="label"><span class="label-text">Date of
                                    Birth</span></label>
                            <input type="date" name="date_of_birth" id="date_of_birth"
                                class="input input-bordered w-full" value="{{ old('date_of_birth') }}">
                        </div>

                        <div class="mt-6">
                            <button type="submit" class="btn btn-primary">Save Customer</button>
                            <a href="{{ route('customers.index') }}" class="btn btn-ghost ml-2">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>