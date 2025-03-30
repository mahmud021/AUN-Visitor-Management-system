<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <!-- Title on the left -->
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Admin Panel') }}
            </h2>
        </div>
    </x-slot>

    <!-- Dashboard Cards -->
    <div class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto bg-primary">
        <h3 class="font-semibold text-lg text-white">
            Time Window
        </h3>

        <form action="{{ route('settings.update') }}" method="POST" class="space-y-6">
            @csrf

            <div class="flex space-x-4">
                <!-- Start Time -->
                <div class="space-y-2 max-w-32">
                    <x-form.input
                        name="visitor_start_time"
                        label="Start Time"
                        type="time"
                        :value="old('visitor_start_time', $settings->visitor_start_time ?? \Carbon\Carbon::now()->format('H:i'))"
                        class="bg-brand-800 border-brand-700 text-brand-100 placeholder-brand-300"
                    />
                    <x-input-error :messages="$errors->get('visitor_start_time')" class="mt-1 text-brand-400"/>
                </div>

                <!-- End Time -->
                <div class="space-y-2 max-w-32">
                    <x-form.input
                        name="visitor_end_time"
                        label="End Time"
                        type="time"
                        :value="old('visitor_end_time', $settings->visitor_end_time ?? \Carbon\Carbon::now()->addHour()->format('H:i'))"
                        class="bg-brand-800 border-brand-700 text-brand-100 placeholder-brand-300"
                    />
                    <x-input-error :messages="$errors->get('visitor_end_time')" class="mt-1 text-brand-400"/>
                </div>
            </div>

            <x-primary-button type="submit" class="bg-brand-700 hover:bg-brand-600 text-white">
                Save
            </x-primary-button>
        </form>
        <hr class="border-gray-500 dark:border-neutral-500 mt-5">

        <a class="flex items-center gap-x-3 py-2 px-3 rounded-lg text-sm text-neutral-200 hover:bg-neutral-700 focus:outline-none focus:bg-neutral-700"
           href="{{ route('visitors.scan') }}">
            Scan QR Code
        </a>

        <hr class="border-gray-500 dark:border-neutral-500 mt-5">
        <h3 class="font-semibold text-lg text-white mt-5">
            Locations
        </h3>

        <!-- Create New Location Form -->
        <form action="{{ route('settings.locations.store') }}" method="POST" class="mt-4">
            @csrf
            <div class="flex items-center gap-2">
                <input type="text" name="name" placeholder="Enter new location" required
                       class="w-100 rounded-md border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:border-blue-500 dark:bg-neutral-800 dark:border-neutral-600 dark:text-white" />
                <x-primary-button>Create Location</x-primary-button>
            </div>
            @error('name')
            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </form>

        <!-- Existing Locations List with Delete Buttons -->
        <div class="flex gap-8 mt-6">
            @foreach($locations->chunk(6) as $chunk)
                <ul class="max-w-xs flex flex-col">
                    @foreach($chunk as $location)
                        <li class="flex justify-between items-center gap-x-3.5 py-3 px-4 text-sm font-medium bg-white border border-gray-200 text-gray-800 -mt-px first:rounded-t-lg first:mt-0 last:rounded-b-lg dark:bg-neutral-900 dark:border-neutral-700 dark:text-white">
                            <!-- Left Side: Location Name -->
                            <span>{{ $location->name }}</span>
                            <!-- Right Side: Delete Button as an "X" -->
                            <form action="{{ route('settings.locations.destroy', $location->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to permanently delete this location?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="flex shrink-0 justify-center items-center gap-2 size-9.5 text-sm font-medium rounded-lg border border-transparent  text-white hover:bg-blue-700 focus:outline-hidden focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <line x1="18" y1="6" x2="6" y2="18"></line>
                                        <line x1="6" y1="6" x2="18" y2="18"></line>
                                    </svg>
                                </button>
                            </form>
                        </li>
                    @endforeach
                </ul>
            @endforeach
        </div>



    </div>
</x-app-layout>
