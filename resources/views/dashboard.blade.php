<x-app-layout>
    <x-slot name="header">
        <!-- Header with Create Visitor and Logout buttons -->
        <x-dashboard.header :user="$user" :locations="$locations"/>
    </x-slot>
    @if(auth()->user()->user_details->blacklist)
        <!-- Blacklisted Warning Banner -->
        <div class="max-w-[85rem] px-4 py-4 sm:px-6 lg:px-8 mx-auto text-center">
            <div
                class="inline-flex items-center bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded-full shadow-md">
            <span class="inline-flex items-center justify-center rounded-full bg-red-200 p-1 mr-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="#DC2626"
                     stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"
                     class="lucide lucide-triangle-alert-icon">
                    <path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3"/>
                    <path d="M12 9v4"/>
                    <path d="M12 17h.01"/>
                </svg>
            </span>
                <p class="text-sm font-semibold">
                    You have been blacklisted. Please contact HR for more information.
                </p>
            </div>
        </div>
    @else
    @endif


    <!-- Dashboard Cards -->
    <div class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto bg-primary">

        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
            <x-dashboard.card
                title="Total Visitors Today"
                :count="$dailyVisitorCount"
                tooltip="The number of visitors today"
                modal-target="hs-total-visitors-modal"/>

            <x-dashboard.card
                title="Active Visitors Today"
                :count="$checkedInVisitorCount"
                tooltip="The number of active users"
                modal-target="hs-basic-modal"/>

            <x-dashboard.card
                title="Overstaying Visitors Today"
                :count="$overstayingVisitorCount"
                tooltip="The number of overstaying users"
                modal-target="hs-overstaying-modal"/>
        </div>
    </div>

    <!-- Create Visitor Modal -->
    <x-modal name="create-visitor-modal" maxWidth="lg">
        <div class="p-4 bg-brand-900 text-brand-100 overflow-y-auto">
            <h3 class="text-xl font-semibold mb-4">Create Visitor</h3>

            <form method="POST" action="{{ route('visitors.store') }}" onsubmit="disableSubmitButton(this)">
                @csrf

                <div class="grid grid-cols-2 gap-4 lg:gap-4">
                    <!-- First Name -->
                    <div class="space-y-2">
                        <x-form.input name="first_name" label="First Name" type="text"
                                      value="{{ old('first_name') }}"
                                      class="bg-brand-800 border-brand-700 text-brand-100 placeholder-brand-300"/>
                        <x-input-error :messages="$errors->get('first_name')" class="mt-1 text-brand-400"/>
                    </div>

                    <!-- Last Name -->
                    <div class="space-y-2">
                        <x-form.input name="last_name" label="Last Name" type="text"
                                      value="{{ old('last_name') }}"
                                      class="bg-brand-800 border-brand-700 text-brand-100 placeholder-brand-300"/>
                        <x-input-error :messages="$errors->get('last_name')" class="mt-1 text-brand-400"/>
                    </div>

                    <!-- Telephone Number -->
                    <div class="space-y-2">
                        <x-form.input name="telephone" label="Telephone Number" type="text"
                                      value="{{ old('telephone') }}"
                                      class="bg-brand-800 border-brand-700 text-brand-100 placeholder-brand-300"/>
                        <x-input-error :messages="$errors->get('telephone')" class="mt-1 text-brand-400"/>
                    </div>

                    <!-- Visit Date -->
                    <div class="space-y-2">
                        <x-form.input name="visit_date" label="Visit Date" type="date"
                                      value="{{ old('visit_date', \Carbon\Carbon::now()->toDateString()) }}"
                                      class="bg-brand-800 border-brand-700 text-brand-100 placeholder-brand-300"/>
                        <x-input-error :messages="$errors->get('visit_date')" class="mt-1 text-brand-400"/>
                    </div>

                    <!-- Start Time -->
                    <div class="space-y-2">
                        <x-form.input name="start_time" label="Start Time" type="time"
                                      value="{{ old('start_time', \Carbon\Carbon::now()->format('H:i')) }}"
                                      class="bg-brand-800 border-brand-700 text-brand-100 placeholder-brand-300"/>
                        <x-input-error :messages="$errors->get('start_time')" class="mt-1 text-brand-400"/>
                    </div>

                    <!-- End Time -->
                    <div class="space-y-2">
                        <x-form.input name="end_time" label="End Time" type="time"
                                      value="{{ old('end_time', \Carbon\Carbon::now()->addHour()->format('H:i')) }}"
                                      class="bg-brand-800 border-brand-700 text-brand-100 placeholder-brand-300"/>
                        <x-input-error :messages="$errors->get('end_time')" class="mt-1 text-brand-400"/>
                    </div>

                    <!-- Location -->
                    <div class="space-y-2 col-span-2">
                        <x-form.select name="location" label="Location">
                            <option value="" disabled selected>Select a location</option>
                            @foreach($locations as $location)
                                <option
                                    value="{{ $location->name }}" {{ old('location') == $location->name ? 'selected' : '' }}>
                                    {{ $location->name }}
                                </option>
                            @endforeach
                        </x-form.select>
                        <x-input-error :messages="$errors->get('location')" class="mt-1 text-brand-400"/>
                    </div>

                    <!-- Purpose of Visit -->
                    <div class="space-y-2 col-span-2">
                        <x-form.input name="purpose_of_visit" label="Purpose of Visit"
                                         class="bg-brand-800 border-brand-700 text-brand-100 placeholder-brand-300"
                                         rows="3">{{ old('purpose_of_visit') }}</x-form.input>
                        <x-input-error :messages="$errors->get('purpose_of_visit')" class="mt-1 text-brand-400"/>
                    </div>
                </div>

                <div class="mt-6 flex justify-end gap-x-2 bg-brand-900 py-3 px-4 rounded-md border-t border-brand-700">
                    <button type="button"
                            class="px-4 py-2 bg-brand-700 hover:bg-brand-600 text-white rounded-md transition"
                            @click.prevent="$dispatch('close-modal', 'create-visitor-modal')">
                        Cancel
                    </button>

                    <x-primary-button type="submit" class="bg-brand-700 hover:bg-brand-600 text-white">
                        Submit
                    </x-primary-button>
                </div>
            </form>
        </div>
    </x-modal>

    <x-modal name="walk-in-modal" maxWidth="lg">
        <div class="p-4 bg-brand-900 text-brand-100 overflow-y-auto">
            <h3 class="text-xl font-semibold mb-4">Add Walk-In Visitor</h3>

            <form method="POST" action="{{ route('visitors.store') }}" onsubmit="disableSubmitButton(this)">
                @csrf

                <div class="grid grid-cols-2 gap-4 lg:gap-4">
                    <!-- First Name -->
                    <div class="space-y-2">
                        <x-form.input name="first_name" label="First Name" type="text"
                                      value="{{ old('first_name') }}"
                                      class="bg-brand-800 border-brand-700 text-brand-100 placeholder-brand-300"/>
                        <x-input-error :messages="$errors->get('first_name')" class="mt-1 text-brand-400"/>
                    </div>

                    <!-- Last Name -->
                    <div class="space-y-2">
                        <x-form.input name="last_name" label="Last Name" type="text"
                                      value="{{ old('last_name') }}"
                                      class="bg-brand-800 border-brand-700 text-brand-100 placeholder-brand-300"/>
                        <x-input-error :messages="$errors->get('last_name')" class="mt-1 text-brand-400"/>
                    </div>

                    <!-- Telephone -->
                    <div class="space-y-2">
                        <x-form.input name="telephone" label="Telephone" type="text"
                                      value="{{ old('telephone') }}"
                                      class="bg-brand-800 border-brand-700 text-brand-100 placeholder-brand-300"/>
                        <x-input-error :messages="$errors->get('telephone')" class="mt-1 text-brand-400"/>
                    </div>

                    <!-- End Time -->
                    <div class="space-y-2">
                        <x-form.input name="end_time" label="End Time" type="time"
                                      value="{{ old('end_time', \Carbon\Carbon::now()->addHour()->format('H:i')) }}"
                                      class="bg-brand-800 border-brand-700 text-brand-100 placeholder-brand-300"/>
                        <x-input-error :messages="$errors->get('end_time')" class="mt-1 text-brand-400"/>
                    </div>

                    <!-- Location (full width) -->
                    <div class="space-y-2 col-span-2">
                        <x-form.select name="location" label="Location">
                            <option value="" disabled selected>Select a location</option>
                            @foreach($locations as $location)
                                <option value="{{ $location->name }}" {{ old('location') == $location->name ? 'selected' : '' }}>
                                    {{ $location->name }}
                                </option>
                            @endforeach
                        </x-form.select>
                        <x-input-error :messages="$errors->get('location')" class="mt-1 text-brand-400"/>
                    </div>

                    <!-- Purpose of Visit (full width) -->
                    <div class="space-y-2 col-span-2">
                        <x-form.input name="purpose_of_visit" label="Purpose of Visit" type="text"
                                      value="{{ old('purpose_of_visit') }}"
                                      class="bg-brand-800 border-brand-700 text-brand-100 placeholder-brand-300"/>
                        <x-input-error :messages="$errors->get('purpose_of_visit')" class="mt-1 text-brand-400"/>
                    </div>

                    <!-- Hidden auto-filled values -->
                    <input type="hidden" name="walk_in" value="true">
                    <input type="hidden" name="visit_date" value="{{ \Carbon\Carbon::now()->toDateString() }}">
                    <input type="hidden" name="start_time" value="{{ \Carbon\Carbon::now()->format('H:i') }}">
                </div>

                <!-- Footer -->
                <div class="mt-6 flex justify-end gap-x-2 bg-brand-900 py-3 px-4 rounded-md border-t border-brand-700">
                    <button type="button"
                            class="px-4 py-2 bg-brand-700 hover:bg-brand-600 text-white rounded-md transition"
                            @click.prevent="$dispatch('close-modal', 'walk-in-modal')">
                        Cancel
                    </button>

                    <x-primary-button type="submit" class="bg-brand-700 hover:bg-brand-600 text-white">
                        Submit
                    </x-primary-button>
                </div>
            </form>
        </div>
    </x-modal>

    <x-modal name="inventory-modal" maxWidth="2xl">
        <div class="p-4 bg-brand-900 text-brand-100 overflow-y-auto">
            <h3 class="text-xl font-semibold mb-4">Add Appliance</h3>

            <form method="POST" action="{{ route('inventory.store') }}" enctype="multipart/form-data"
                  onsubmit="disableSubmitButton(this)">
                @csrf

                <div class="grid grid-cols-1 gap-4 lg:gap-4">
                    <!-- Appliance Name -->
                    <div class="space-y-2">
                        <x-form.input name="appliance_name" label="Appliance Name" type="text"
                                      value="{{ old('appliance_name') }}"
                                      class="bg-brand-800 border-brand-700 text-brand-100 placeholder-brand-300"/>
                        <x-input-error :messages="$errors->get('appliance_name')" class="mt-1 text-brand-400"/>
                    </div>

                    <div class="space-y-2">
                        <x-form.input name="brand" label="Brand" type="text"
                                      value="{{ old('brand') }}"
                                      class="bg-brand-800 border-brand-700 text-brand-100 placeholder-brand-300"/>
                        <x-input-error :messages="$errors->get('brand')" class="mt-1 text-brand-400"/>
                    </div>

                    <!-- Location -->
                    <div class="space-y-2">
                        <x-form.select name="location" label="Location">
                            <option value="" disabled selected>Select a location</option>
                            @foreach($locations as $location)
                                <option
                                    value="{{ $location->name }}" {{ old('location') == $location->name ? 'selected' : '' }}>
                                    {{ $location->name }}
                                </option>
                            @endforeach
                        </x-form.select>
                        <x-input-error :messages="$errors->get('location')" class="mt-1 text-brand-400"/>
                    </div>

                    <!-- Image Upload -->
                    <div class="space-y-2">
                        <x-form.input name="image" label="Appliance Image" type="file" accept="image/*"
                                      class="bg-brand-800 border-brand-700 text-brand-100 placeholder-brand-300"/>
                        <x-input-error :messages="$errors->get('image')" class="mt-1 text-brand-400"/>
                    </div>
                </div>

                <div class="mt-6 flex justify-end gap-x-2 bg-brand-900 py-3 px-4 rounded-md border-t border-brand-700">
                    <button type="button"
                            class="px-4 py-2 bg-brand-700 hover:bg-brand-600 text-white rounded-md transition"
                            @click.prevent="$dispatch('close-modal', 'inventory-modal')">
                        Cancel
                    </button>

                    <x-primary-button type="submit" class="bg-brand-700 hover:bg-brand-600 text-white">
                        Submit
                    </x-primary-button>
                </div>
            </form>
        </div>
    </x-modal>


    <!-- Other Modals (Total Visitors, Active Visitors, Overstaying Visitors) -->
    <x-dashboard.modals
        :totalVisitors="$totalVisitors"
        :checkedInVisitors="$checkedInVisitors"
        :overstayingVisitors="$overstayingVisitors"/>

    <!-- Additional Dashboard Content -->
    <div class="py-12 bg-primary text-white min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="flex justify-center">
                <div class="max-w-lg w-full">

                    <!-- Normal (non-plugin) Search Form -->
                    <div class="relative">
                        <div class="absolute inset-y-0 start-0 flex items-center pointer-events-none z-20 ps-3.5">
                            <svg class="shrink-0 size-4 text-gray-400 dark:text-white/60"
                                 xmlns="http://www.w3.org/2000/svg"
                                 width="24"
                                 height="24"
                                 viewBox="0 0 24 24"
                                 fill="none"
                                 stroke="currentColor"
                                 stroke-width="2"
                                 stroke-linecap="round"
                                 stroke-linejoin="round">
                                <circle cx="11" cy="11" r="8"></circle>
                                <path d="m21 21-4.3-4.3"></path>
                            </svg>
                        </div>

                        <form action="/search" method="GET">
                            <input
                                name="q"
                                class="py-2.5 py-3 ps-10 pe-4 block w-full border-gray-200 rounded-lg
                 sm:text-sm focus:border-blue-500 focus:ring-blue-500
                 disabled:opacity-50 disabled:pointer-events-none
                 dark:bg-neutral-900 dark:border-neutral-700
                 dark:text-neutral-400 dark:placeholder-neutral-500
                 dark:focus:ring-neutral-600"
                                type="text"
                                placeholder="Search Visitors"
                            />
                        </form>
                    </div>
                    <!-- End Normal Search Form -->

                </div>
            </div>




            <div class="overflow-hidden shadow-sm sm:rounded-lg">
                @can('view-all-visitors')
                    @include('dashboard.allVisitors')
                @endcan

                @include('dashboard.myVisitors')
            </div>
        </div>
    </div>
</x-app-layout>
