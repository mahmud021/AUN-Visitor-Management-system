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
                        <x-primary-button type="button"
                                          aria-haspopup="dialog"
                                          aria-expanded="false"
                                          aria-controls="inventory-modal"
                                          data-hs-overlay="#inventory-modal">
                            Create Appliance
                        </x-primary-button>

                        <form method="POST" action="{{ route('inventory.store') }}" enctype="multipart/form-data">
                            @csrf
                            <x-modal.wrapper id="inventory-modal">
                                <x-modal.header title="Add Appliance" modalId="inventory-modal"/>
                                <div class="p-4 overflow-y-auto">
                                    <div class="grid grid-cols-1 gap-4 lg:gap-4">
                                        <!-- Appliance Name -->
                                        <div class="space-y-2">
                                            <x-form.input name="appliance_name" label="Appliance Name" type="text" value="{{ old('appliance_name') }}" required/>
                                            <x-input-error :messages="$errors->get('appliance_name')" class="mt-1"/>
                                        </div>

                                        <!-- Location -->
                                        <div class="space-y-2">
                                            <x-form.input name="location" label="Location" type="text" value="{{ old('location') }}"/>
                                            <x-input-error :messages="$errors->get('location')" class="mt-1"/>
                                        </div>

                                        <!-- Image Upload -->
                                        <div class="space-y-2">
                                            <x-form.input name="image" label="Appliance Image" type="file" accept="image/*"/>
                                            <x-input-error :messages="$errors->get('image')" class="mt-1"/>
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
                        @foreach ($inventory as $inventory)
                            <x-table-row>
                                <td class="size-px whitespace-nowrap"></td>

                                <!-- Name Column -->
                                <td class="size-px whitespace-nowrap">
                                    <div class="ps-6 lg:ps-3 xl:ps-0 pe-6 py-3">
                                        <div class="flex items-center gap-x-3">
                                            <div class="grow">
                                                <span class="block text-sm font-semibold text-neutral-200">
                                                    {{ $inventory->appliance_name ?? 'Null' }}
                                                </span>
                                                @if($inventory->user)
                                                    <span class="block text-sm text-neutral-500">
                                                        Owned by: {{ $inventory->user->user_details->school_id ?? 'Null' }}
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
                                            {{ $inventory->location ?? 'Null' }}
                                        </span>
                                    </div>
                                </td>

                                <!-- Checked In Arrival Column -->
                                <td class="size-px whitespace-nowrap">
                                    <div class="px-6 py-3">
                                        <span class="block text-sm text-neutral-500">
                                            {{ \Carbon\Carbon::parse($inventory->checked_in_at)->format('M d, h:i A') }}
                                        </span>
                                    </div>
                                </td>

                                <!-- Status Column -->
                                <td class="size-px whitespace-nowrap">
                                    <div class="px-6 py-3">
                                        <x-status-badge status="{{ $inventory->status }}"/>
                                    </div>
                                </td>

                                <!-- Created Column -->
                                <td class="size-px whitespace-nowrap">
                                    <div class="px-6 py-3">
                                        <span class="text-sm text-neutral-500">
                                            {{ \Carbon\Carbon::parse($inventory->created_at)->format('d M, Y') }}
                                        </span>
                                    </div>
                                </td>

                                <!-- Actions Dropdown -->
                                <td class="size-px whitespace-nowrap">
                                    <div class="px-6 py-2">
                                        <div class="hs-dropdown [--placement:bottom-right] relative inline-block">
                                            <button
                                                id="hs-table-dropdown-{{ $inventory->id }}"
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
                                                aria-labelledby="hs-table-dropdown-{{ $inventory->id }}"
                                            >

                                                <!-- Actions Section -->
                                                <div class="py-2">
                                                    <span class="block py-2 px-3 text-xs font-medium uppercase text-neutral-400">
                                                        Actions
                                                    </span>

                                                    {{-- Example Edit link --}}
                                                    <a href="{{ route('visitors.edit', $inventory->id) }}" class="flex items-center gap-x-3 py-2 px-3 rounded-lg text-sm text-neutral-200 hover:bg-neutral-700 focus:outline-none focus:bg-neutral-700">
                                                        Edit
                                                    </a>

                                                    {{-- Timeline link --}}
                                                    <a class="flex items-center gap-x-3 py-2 px-3 rounded-lg text-sm text-neutral-200 hover:bg-neutral-700 focus:outline-none focus:bg-neutral-700"
                                                       href="{{ route('visitors.timeline', $inventory->id) }}">
                                                        View Timeline
                                                    </a>

                                                    @if($inventory->status == 'pending')
                                                        <form action="{{ route('visitors.update', $inventory->id) }}" method="POST" style="display: inline;">
                                                            @csrf
                                                            @method('PATCH')
                                                            <input type="hidden" name="status" value="approved">
                                                            <button type="submit" class="flex items-center gap-x-3 py-2 px-3 rounded-lg text-sm text-neutral-200 hover:bg-neutral-700 focus:outline-none focus:bg-neutral-700">
                                                                Approve
                                                            </button>
                                                        </form>
                                                    @elseif($inventory->status == 'approved')
                                                        <form action="{{ route('visitors.update', $inventory->id) }}" method="POST" style="display: inline;">
                                                            @csrf
                                                            @method('PATCH')
                                                            <input type="hidden" name="status" value="checked_in">
                                                            <button type="submit" class="flex items-center gap-x-3 py-2 px-3 rounded-lg text-sm text-neutral-200 hover:bg-neutral-700 focus:outline-none focus:bg-neutral-700">
                                                                Check In
                                                            </button>
                                                        </form>
                                                    @elseif($inventory->status == 'checked_in')
                                                        <form action="{{ route('visitors.update', $inventory->id) }}" method="POST" style="display: inline;">
                                                            @csrf
                                                            @method('PATCH')
                                                            <input type="hidden" name="status" value="checked_out">
                                                            <button type="submit" class="flex items-center gap-x-3 py-2 px-3 rounded-lg text-sm text-neutral-200 hover:bg-neutral-700 focus:outline-none focus:bg-neutral-700">
                                                                Check Out
                                                            </button>
                                                        </form>
                                                    @endif
                                                </div>

                                                <!-- Delete Section -->
                                                <div class="py-2">
                                                    <a class="flex items-center gap-x-3 py-2 px-3 rounded-lg text-sm text-red-500 hover:bg-neutral-700 focus:outline-none focus:bg-neutral-700"
                                                       href="/visitor/{{ $inventory->id }}/delete">
                                                        Delete
                                                    </a>
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
                    </x-slot>
                </x-table-footer>
            </x-table-wrapper>
            <!-- End Table Section -->
        </div>
    </div>
</x-app-layout>
