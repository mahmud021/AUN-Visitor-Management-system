<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <!-- Title on the left -->
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Appointment') }}
            </h2>

            <!-- Button (and its modal form) on the right -->
            <div>
                <!-- Button to open the modal -->
                <x-primary-button
                    type="button"
                    aria-haspopup="dialog"
                    aria-expanded="false"
                    aria-controls="hs-scale-animation-modal"
                    data-hs-overlay="#hs-scale-animation-modal"
                >
                    Create Visitor
                </x-primary-button>

                <!-- Modal Form -->
                {{-- IMPORTANT: Use the route name for storing visitors (visitors.store) --}}
                <form method="POST" action="{{ route('visitors.store') }}">
                    @csrf

                    <x-modal.wrapper id="hs-scale-animation-modal">
                        <x-modal.header
                            title="Create Visitor"
                            modalId="hs-scale-animation-modal"
                        />

                        <div class="p-4 overflow-y-auto">
                            <div class="grid grid-cols-1 gap-4 lg:gap-4">
                                <!-- First Name -->
                                <div class="space-y-2">
                                    <x-form.input name="first_name" label="First Name" type="text" value="{{ old('first_name') }}"/>
                                    <x-input-error :messages="$errors->get('first_name')" class="mt-1"/>
                                </div>
                                <!-- Last Name -->
                                <div class="space-y-2">
                                    <x-form.input name="last_name" label="Last Name" type="text" value="{{ old('last_name') }}"/>
                                    <x-input-error :messages="$errors->get('last_name')" class="mt-1"/>
                                </div>
                                <!-- Telephone -->
                                <div class="space-y-2">
                                    <x-form.input name="telephone" label="Telephone Number" type="text" value="{{ old('telephone') }}"/>
                                    <x-input-error :messages="$errors->get('telephone')" class="mt-1"/>
                                </div>
                                <!-- Expected Arrival -->
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
                        </div>

                        <x-modal.footer>
                            <x-primary-button type="submit">
                                Submit
                            </x-primary-button>
                        </x-modal.footer>
                    </x-modal.wrapper>
                </form>
            </div>
        </div>


    </x-slot>


    <div class="py-12 bg-white dark:bg-gray-900">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden shadow-sm sm:rounded-lg">
                <div class="flex flex-col bg-white border shadow-sm rounded-xl dark:bg-neutral-900 dark:border-neutral-700 dark:shadow-neutral-700/70">
                    <div class="p-4 md:p-10">
                        <h3 class="text-lg font-bold text-gray-800 dark:text-white">
                            Create An Appointment
                        </h3>
                        <div class="flex flex-col gap-y-3">
                            <div class="flex">
                                <input type="radio" name="hs-radio-vertical-group" class="shrink-0 mt-0.5 border-gray-200 rounded-full text-blue-600 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800" id="hs-radio-vertical-group-1" checked="">
                                <label for="hs-radio-vertical-group-1" class="text-sm text-gray-500 ms-2 dark:text-neutral-400">Apple</label>
                            </div>

                            <div class="flex">
                                <input type="radio" name="hs-radio-vertical-group" class="shrink-0 mt-0.5 border-gray-200 rounded-full text-blue-600 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800" id="hs-radio-vertical-group-2">
                                <label for="hs-radio-vertical-group-2" class="text-sm text-gray-500 ms-2 dark:text-neutral-400">Pear</label>
                            </div>

                            <div class="flex">
                                <input type="radio" name="hs-radio-vertical-group" class="shrink-0 mt-0.5 border-gray-200 rounded-full text-blue-600 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800" id="hs-radio-vertical-group-3">
                                <label for="hs-radio-vertical-group-3" class="text-sm text-gray-500 ms-2 dark:text-neutral-400">Orange</label>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

</x-app-layout>
