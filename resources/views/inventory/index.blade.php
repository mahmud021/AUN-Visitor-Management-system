<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-neutral-200 leading-tight">
            {{ __('Inventory') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Table Section -->
            <x-table-wrapper>
                <x-table-header title="Inventory" description="View and Manage All Appliances.">
                    <x-slot name="actions">
                        <div class="relative max-w-xs">
                            <label for="hs-table-search" class="sr-only">Search</label>
                            <form action="{{ route('inventory.search') }}" method="GET">
                                <input type="text" name="q" class="py-1.5 sm:py-2 px-3 ps-9 block w-full border-gray-200 shadow-2xs rounded-lg sm:text-sm focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600" placeholder="Search Inventory" value="{{ request()->input('q') }}">
                            </form>
                            <div class="absolute inset-y-0 start-0 flex items-center pointer-events-none ps-3">
                                <svg class="size-4 text-gray-400 dark:text-neutral-500" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="11" cy="11" r="8"></circle>
                                    <path d="m21 21-4.3-4.3"></path>
                                </svg>
                            </div>
                        </div>
                        <!-- Reset Search Button -->
                        @if(request()->has('q')) <!-- Show Reset button if there's a query -->
                        <form action="{{ route('inventory.index') }}" method="GET">
                            <x-primary-button type="submit" >
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-list-restart-icon lucide-list-restart"><path d="M21 6H3"/><path d="M7 12H3"/><path d="M7 18H3"/><path d="M12 18a5 5 0 0 0 9-3 4.5 4.5 0 0 0-4.5-4.5c-1.33 0-2.54.54-3.41 1.41L11 14"/><path d="M11 10v4h4"/></svg>                            </x-primary-button>
                        </form>
                        @endif
                        <x-primary-button
                            type="button"
                            x-data
                            @click="$dispatch('open-modal', 'inventory-modal')"
                        >
                            Register An Appliance
                        </x-primary-button>

                        <x-modal name="inventory-modal" maxWidth="2xl">
                            <div class="p-4 bg-brand-900 text-brand-100 overflow-y-auto">
                                <h3 class="text-xl font-semibold mb-4">Add Appliance</h3>

                                <form method="POST" action="{{ route('inventory.store') }}" enctype="multipart/form-data" onsubmit="disableSubmitButton(this)">
                                    @csrf

                                    <div class="grid grid-cols-1 gap-4 lg:gap-4">


                                            <x-form.select name="student_id" label="Select Student">
                                                <option value="" disabled selected>Select a student</option>
                                                @foreach($users as $user)
                                                    <option value="{{ $user->user->id}}">{{ $user->school_id ?? 'Null' }} {{ $user->user->last_name ?? 'Null' }} </option>
                                                @endforeach
                                            </x-form.select>
                                            <x-input-error :messages="$errors->get('student_id')" class="mt-1 text-brand-400"/>


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
                                                    <option value="{{ $location->name }}" {{ old('location', $inventory->location ?? '') == $location->name ? 'selected' : '' }}>
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

                    </x-slot>
                </x-table-header>

                <x-table>
                    <x-slot name="header">
                        <tr>
                            <th scope="col" class="ps-6 py-3 text-start"></th>
                            <th scope="col" class="ps-6 lg:ps-3 xl:ps-0 pe-6 py-3 text-start">
                                <div class="flex items-center gap-x-2">
                                    <span class="text-xs font-semibold uppercase tracking-wide text-neutral-200">
                                        Name
                                    </span>
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3 text-start">
                                <div class="flex items-center gap-x-2">
                                    <span class="text-xs font-semibold uppercase tracking-wide text-neutral-200">
                                        Location
                                    </span>
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3 text-start">
                                <div class="flex items-center gap-x-2">
                                    <span class="text-xs font-semibold uppercase tracking-wide text-neutral-200">
                                        Checked In Time
                                    </span>
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3 text-start">
                                <div class="flex items-center gap-x-2">
                                    <span class="text-xs font-semibold uppercase tracking-wide text-neutral-200">
                                        Status
                                    </span>
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3 text-start">
                                <div class="flex items-center gap-x-2">
                                    <span class="text-xs font-semibold uppercase tracking-wide text-neutral-200">
                                        Created
                                    </span>
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3 text-end"></th>
                        </tr>
                    </x-slot>

                    <x-slot name="rows">
                        @foreach ($inventory as $item)
                            <x-table-row>
                                <td class="size-px whitespace-nowrap"></td>

                                <!-- Name Column -->
                                <td class="size-px whitespace-nowrap">
                                    <div class="ps-6 lg:ps-3 xl:ps-0 pe-6 py-3">
                                        <div class="flex items-center gap-x-3">
                                            <div class="grow">
                                                <span class="block text-sm font-semibold text-neutral-200">
                                                    {{ $item->appliance_name ?? 'Null' }}
                                                </span>
                                                @if($item->user)
                                                    <span class="block text-sm text-neutral-500">
                                                        Owned by: {{ $item->user->user_details->school_id ?? 'Null' }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <!-- Location Column -->
                                <td class="size-px whitespace-nowrap">
                                    <div class="px-6 py-3">
                                        <span class="block text-sm font-semibold text-neutral-200">
                                            {{ $item->location ?? 'Null' }}
                                        </span>
                                    </div>
                                </td>

                                <!-- Checked In Arrival Column -->
                                <td class="size-px whitespace-nowrap">
                                    <div class="px-6 py-3">
                                        <span class="block text-sm text-neutral-500">
                                            {{ \Carbon\Carbon::parse($item->checked_in_at)->format('M d, h:i A') }}
                                        </span>
                                    </div>
                                </td>

                                <!-- Status Column -->
                                <td class="size-px whitespace-nowrap">
                                    <div class="px-6 py-3">
                                        <x-status-badge status="{{ $item->status }}"/>
                                    </div>
                                </td>

                                <!-- Created Column -->
                                <td class="size-px whitespace-nowrap">
                                    <div class="px-6 py-3">
                                        <span class="text-sm text-neutral-500">
                                            {{ \Carbon\Carbon::parse($item->created_at)->format('d M, Y') }}
                                        </span>
                                    </div>
                                </td>

                                <!-- Actions Dropdown -->
                                <td class="size-px whitespace-nowrap">
                                    <div class="px-6 py-2">
                                        <div class="hs-dropdown [--placement:bottom-right] relative inline-block">
                                            <button
                                                id="hs-table-dropdown-{{ $item->id }}"
                                                type="button"
                                                class="hs-dropdown-toggle py-1.5 px-2 inline-flex justify-center items-center gap-2 rounded-lg text-neutral-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-600 text-sm"
                                                aria-haspopup="menu"
                                                aria-expanded="false"
                                                aria-label="Dropdown"
                                            >
                                                <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg"
                                                     width="24" height="24" fill="none" stroke="currentColor"
                                                     stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <circle cx="12" cy="12" r="1"/>
                                                    <circle cx="19" cy="12" r="1"/>
                                                    <circle cx="5" cy="12" r="1"/>
                                                </svg>
                                            </button>
                                            <div
                                                class="hs-dropdown-menu transition-[opacity,margin] duration hs-dropdown-open:opacity-100 opacity-0 hidden divide-y divide-neutral-700 min-w-40 z-20 bg-neutral-800 shadow-2xl rounded-lg p-2 mt-2 border border-neutral-700"
                                                role="menu"
                                                aria-orientation="vertical"
                                                aria-labelledby="hs-table-dropdown-{{ $item->id }}"
                                            >

                                                <!-- Actions Section -->
                                                <div class="py-2">
                                                    <span class="block py-2 px-3 text-xs font-medium uppercase text-neutral-400">
                                                        Actions
                                                    </span>

                                                    {{-- Example Edit link --}}
                                                    <a href="{{ route('inventory.show', $item->id) }}" class="flex items-center gap-x-3 py-2 px-3 rounded-lg text-sm text-neutral-200 hover:bg-neutral-700 focus:outline-none focus:bg-neutral-700">
                                                        View Item
                                                    </a>
                                                    <a href="{{ route('inventory.edit', $item->id) }}" class="flex items-center gap-x-3 py-2 px-3 rounded-lg text-sm text-neutral-200 hover:bg-neutral-700 focus:outline-none focus:bg-neutral-700">
                                                        Edit Item
                                                    </a>

                                                    {{-- Timeline link --}}
                                                    <a class="flex items-center gap-x-3 py-2 px-3 rounded-lg text-sm text-neutral-200 hover:bg-neutral-700 focus:outline-none focus:bg-neutral-700"
                                                       href="{{ route('inventory.timeline', $item->id) }}">
                                                        View Timeline
                                                    </a>
                                                </div>

                                                <!-- Delete Section -->
                                                <div class="py-2">

                                                </div>
                                                <!-- End Delete Section -->

                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <!-- End Actions Dropdown -->

                            </x-table-row>
                        @endforeach
                    </x-slot>
                </x-table>

                <x-table-footer totalResults="">
                    <x-slot name="pagination">
                        {{ $inventory->links() }}
                    </x-slot>
                </x-table-footer>

            </x-table-wrapper>
            <!-- End Table Section -->
        </div>
    </div>
</x-app-layout>
