<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Violation') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('violations.update', $violation) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <x-input-label for="code" :value="__('Code')" />
                            <x-text-input id="code" class="block mt-1 w-full" type="text" name="code"
                                :value="old('code', $violation->code)" required autofocus />
                            <x-input-error :messages="$errors->get('code')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="description" :value="__('Description')" />
                            <textarea id="description" class="textarea textarea-bordered block mt-1 w-full"
                                name="description" required>{{ old('description', $violation->description) }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="penalty_amount" :value="__('Penalty Amount')" />
                            <x-text-input id="penalty_amount" class="block mt-1 w-full" type="number"
                                name="penalty_amount" :value="old('penalty_amount', $violation->penalty_amount)"
                                required step="0.01" />
                            <x-input-error :messages="$errors->get('penalty_amount')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="demerit_points" :value="__('Demerit Points')" />
                            <x-text-input id="demerit_points" class="block mt-1 w-full" type="number"
                                name="demerit_points" :value="old('demerit_points', $violation->demerit_points)"
                                required />
                            <x-input-error :messages="$errors->get('demerit_points')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="category" :value="__('Category')" />
                            <x-text-input id="category" class="block mt-1 w-full" type="text" name="category"
                                :value="old('category', $violation->category)" />
                            <x-input-error :messages="$errors->get('category')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('violations.index') }}" class="btn btn-secondary mr-2">Cancel</a>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>