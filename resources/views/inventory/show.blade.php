<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-neutral-200 leading-tight">
            {{ __('Inventory Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <!-- Carousel and Details -->
        <div class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
            <div class="grid sm:grid-cols-2 sm:items-start gap-8">
                <!-- Left Column: Item Details -->
                <div>
                    <div class="px-4 sm:px-0">
                        <h3 class="text-base/7 font-semibold text-brand-50"></h3>
                        <p class="mt-1 max-w-2xl text-sm/6 text-brand-300">Item details.</p>
                    </div>
                    <div class="mt-6 border-t border-brand-800 ">
                        <dl class="divide-y divide-brand-800">
                            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                <dt class="text-sm/6 font-medium text-brand-50">Appliance Name</dt>
                                <dd class="mt-1 text-sm/6 text-brand-200 sm:col-span-2 sm:mt-0">
                                    {{$inventory->appliance_name ?? 'Null' }}
                                </dd>
                            </div>
                            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                <dt class="text-sm/6 font-medium text-brand-50">Appliance Brand</dt>
                                <dd class="mt-1 text-sm/6 text-brand-200 sm:col-span-2 sm:mt-0">
                                    {{$inventory->brand ?? 'Null' }}
                                </dd>
                            </div>
                            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                <dt class="text-sm/6 font-medium text-brand-50">Current Location</dt>
                                <dd class="mt-1 text-sm/6 text-brand-200 sm:col-span-2 sm:mt-0">
                                    {{$inventory->location ?? 'Null' }}
                                </dd>
                            </div>

                            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                <dt class="text-sm/6 font-medium text-brand-50">Status</dt>
                                <dd class="mt-1 text-sm/6 text-brand-200 sm:col-span-2 sm:mt-0">
                                    <x-status-badge status="{{ $inventory->status ?? 'Null' }}" />
                                </dd>
                            </div>
                            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                <dt class="text-sm/6 font-medium text-brand-50">Telephone</dt>
                                <dd class="mt-1 text-sm/6 text-brand-200 sm:col-span-2 sm:mt-0">
                                    {{ \Carbon\Carbon::parse($inventory->created_at)->format('d M, Y') }}
                                </dd>
                            </div>
                            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                <dt class="text-sm/6 font-medium text-brand-50">Action Button</dt>
                            @if($inventory->status === 'pending')
                                    {{-- Show "Check In" button if status is "pending" --}}
                                    <form action="{{ route('inventory.update', $inventory->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="checked_in">
                                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md">
                                            Check In
                                        </button>
                                    </form>

                                @elseif($inventory->status === 'checked_in')
                                    {{-- Show "Check Out" button if status is "checked_in" --}}
                                    <form action="{{ route('inventory.update', $inventory->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="checked_out">
                                        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md">
                                            Check Out
                                        </button>
                                    </form>

                                @elseif($inventory->status === 'checked_out')
                                    {{-- Show "Check In" button again if status is "checked_out" --}}
                                    <form action="{{ route('inventory.update', $inventory->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="checked_in">
                                        <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md">
                                            Check In
                                        </button>
                                    </form>
                                @endif
                            </div>


                        </dl>
                    </div>
                </div>

                <!-- Right Column: Item Image -->
                <div class="flex justify-center sm:justify-end items-start">
                    <div class="max-w-sm w-full">
                        <!-- Adjust the `asset('...')` part to match the actual path to your image -->
                        @if(!empty($inventory->image_path))
                            <img
                                src="{{ asset('storage/' . $inventory->image_path) }}"
                                alt="Item Image"
                                class="rounded-lg shadow-md object-cover w-full h-auto"
                            >
                        @else
                            <img
                                src="{{ asset('images/placeholder.png') }}"
                                alt="No Image"
                                class="rounded-lg shadow-md object-cover w-full h-auto"
                            >
                        @endif

                    </div>
                </div>
            </div>
        </div>
        <!-- End Carousel and Details -->

        <!-- Inventory Timeline Table -->
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-10">
            <x-table-wrapper>
                <x-table-header title="Appliance Timeline" description="Check-in and Check-out Details of Appliance.">
                    <x-slot name="actions">
                        <!-- Leave empty if no actions are required -->
                    </x-slot>
                </x-table-header>

                <x-table>
                    <x-slot name="header">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-start">
                                <span class="text-xs font-semibold uppercase tracking-wide text-neutral-200">
                                    Checked In Time
                                </span>
                            </th>
                            <th scope="col" class="px-6 py-3 text-start">
                                <span class="text-xs font-semibold uppercase tracking-wide text-neutral-200">
                                    Location
                                </span>
                            </th>
                            <th scope="col" class="px-6 py-3 text-start">
                                <span class="text-xs font-semibold uppercase tracking-wide text-neutral-200">
                                    Checked Out Time
                                </span>
                            </th>
                            <th scope="col" class="px-6 py-3 text-start">
                                <span class="text-xs font-semibold uppercase tracking-wide text-neutral-200">
                                    Status
                                </span>
                            </th>
                        </tr>
                    </x-slot>

                    <x-slot name="rows">
                        <x-table-row>
                            <!-- Checked In Time -->
                            <td class="px-6 py-3 whitespace-nowrap">
                                <span class="text-sm text-neutral-200">
                                    {{ $inventory->checked_in_at
                                        ? \Carbon\Carbon::parse($inventory->checked_in_at)->format('M d, Y h:i A')
                                        : 'N/A'
                                    }}
                                </span>
                            </td>

                            <!-- Location -->
                            <td class="px-6 py-3 whitespace-nowrap">
                                <span class="text-sm text-neutral-200">
                                    {{ $inventory->location ?? 'Not Specified' }}
                                </span>
                            </td>

                            <!-- Checked Out Time -->
                            <td class="px-6 py-3 whitespace-nowrap">
                                <span class="text-sm text-neutral-200">
                                    {{ $inventory->checked_out_at
                                        ? \Carbon\Carbon::parse($inventory->checked_out_at)->format('M d, Y h:i A')
                                        : 'N/A'
                                    }}
                                </span>
                            </td>

                            <!-- Status -->
                            <td class="px-6 py-3 whitespace-nowrap">
                                <x-status-badge status="{{ $inventory->status }}"/>
                            </td>
                        </x-table-row>
                    </x-slot>
                </x-table>

                <x-table-footer :totalResults="''"/>
            </x-table-wrapper>
        </div>
    </div>
</x-app-layout>
