<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <!-- Title on the left -->
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('CREATE a vistor ') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <form method="POST" action="{{ route('visitors.store') }}">
                    @csrf
                    <div class="container mx-auto p-4">
                        <h1 class="text-2xl font-bold mb-4">Create Visitor</h1>
                        <div class="grid grid-cols-1 gap-4">
                            <!-- Form fields for creating a visitor -->
                            <div class="space-y-2">
                                <x-form.input name="first_name" label="First Name" type="text" value="{{ old('first_name') }}"/>
                                <x-input-error :messages="$errors->get('first_name')" class="mt-1"/>
                            </div>
                            <div class="space-y-2">
                                <x-form.input name="last_name" label="Last Name" type="text" value="{{ old('last_name') }}"/>
                                <x-input-error :messages="$errors->get('last_name')" class="mt-1"/>
                            </div>
                            <div class="space-y-2">
                                <x-form.input name="telephone" label="Telephone Number" type="text" value="{{ old('telephone') }}"/>
                                <x-input-error :messages="$errors->get('telephone')" class="mt-1"/>
                            </div>
                            <div class="space-y-2">
                                <x-form.input
                                    name="expected_arrival"
                                    label="Expected Arrival (Date & Time)"
                                    type="datetime-local"
                                    value="{{ old('expected_arrival') }}"
                                />
                                <x-input-error :messages="$errors->get('expected_arrival')" class="mt-1"/>
                            </div>
                        </div>
                        <div class="mt-4">
                            <x-primary-button type="submit">
                                Submit
                            </x-primary-button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
