<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Visitors') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Table Section -->
            <x-table-wrapper>
                <x-table-header title="Visitors" description="Manage your visitor records.">
                    <x-slot name="actions">
                        <x-primary-button type="button"
                                          aria-haspopup="dialog" aria-expanded="false"
                                          aria-controls="hs-scale-animation-modal"
                                          data-hs-overlay="#hs-scale-animation-modal">
                            Create Visitor
                        </x-primary-button>
                        <form method="POST" action="/visitor">
                            @csrf
                            <x-modal.wrapper id="hs-scale-animation-modal">
                                <x-modal.header title="Create Visitor" modalId="hs-scale-animation-modal"/>
                                <div class="p-4 overflow-y-auto">
                                    <div class="grid grid-cols-1 gap-4 lg:gap-4">
                                        <!-- First Name -->
                                        <div class="space-y-2">
                                            <x-form.input name="first_name" label="First Name" type="text"
                                                          value="{{ old('first_name') }}"/>
                                            <x-input-error :messages="$errors->get('first_name')" class="mt-1"/>
                                        </div>
                                        <!-- Last Name -->
                                        <div class="space-y-2">
                                            <x-form.input name="last_name" label="Last Name" type="text"
                                                          value="{{ old('last_name') }}"/>
                                            <x-input-error :messages="$errors->get('last_name')" class="mt-1"/>
                                        </div>
                                        <!-- Telephone -->
                                        <div class="space-y-2">
                                            <x-form.input name="telephone" label="Telephone Number" type="text"
                                                          value="{{ old('telephone') }}"/>
                                            <x-input-error :messages="$errors->get('telephone')" class="mt-1"/>
                                        </div>
                                        <!-- Expected Arrival -->
                                        <div class="space-y-2">
                                            <x-form.input name="expected_arrival" label="Expected Arrival" type="date"
                                                          value="{{ old('expected_arrival') }}"/>
                                            <x-input-error :messages="$errors->get('expected_arrival')" class="mt-1"/>
                                        </div>
                                        <!-- Optional: Status (if you wish to allow manual setting) -->
                                        <!--
                                        <div class="space-y-2">
                                            <x-form.select name="status" label="Status">
                                                <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                                <option value="approved" {{ old('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                                                <option value="denied" {{ old('status') == 'denied' ? 'selected' : '' }}>Denied</option>
                                            </x-form.select>
                                            <x-input-error :messages="$errors->get('status')" class="mt-1"/>
                                        </div>
                                        -->
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
                    <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-neutral-200">
                        Name
                    </span>
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3 text-start">
                                <div class="flex items-center gap-x-2">
                    <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-neutral-200">
                        Telephone
                    </span>
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3 text-start">
                                <div class="flex items-center gap-x-2">
                    <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-neutral-200">
                        Expected Arrival
                    </span>
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3 text-start">
                                <div class="flex items-center gap-x-2">
                    <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-neutral-200">
                        Status
                    </span>
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3 text-start">
                                <div class="flex items-center gap-x-2">
                    <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-neutral-200">
                        Created
                    </span>
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3 text-end"></th>
                        </tr>
                    </x-slot>

                    <x-slot name="rows">
                        @foreach ($visitors as $visitor)
                            <x-table-row>
                                <td class="size-px whitespace-nowrap"></td>

                                <!-- Name Column -->
                                <td class="size-px whitespace-nowrap">
                                    <div class="ps-6 lg:ps-3 xl:ps-0 pe-6 py-3">
                                        <div class="flex items-center gap-x-3">
                                            <div class="grow">
                                <span class="block text-sm font-semibold text-gray-800 dark:text-neutral-200">
                                    {{ $visitor->first_name ?? 'Null' }} {{ $visitor->last_name ?? 'Null' }}
                                </span>
                                                @if($visitor->user)
                                                    <span class="block text-sm text-gray-500 dark:text-neutral-500">
                                        Hosted by: {{ $visitor->user->user_details->school_id ?? 'Null' }}
                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <!-- Telephone Column -->
                                <td class="size-px whitespace-nowrap">
                                    <div class="px-6 py-3">
                        <span class="block text-sm font-semibold text-gray-800 dark:text-neutral-200">
                            {{ $visitor->telephone ?? 'Null' }}
                        </span>
                                    </div>
                                </td>

                                <!-- Expected Arrival Column -->
                                <td class="size-px whitespace-nowrap">
                                    <div class="px-6 py-3">
                        <span class="block text-sm text-gray-500 dark:text-neutral-500">
                            {{ \Carbon\Carbon::parse($visitor->expected_arrival)->format('M d, h:i A') }}
                        </span>
                                    </div>
                                </td>

                                <!-- Status Column -->
                                <td class="size-px whitespace-nowrap">
                                    <div class="px-6 py-3">
                                        <x-status-badge status="{{ $visitor->status }}"/>
                                    </div>
                                </td>

                                <!-- Created Column -->
                                <td class="size-px whitespace-nowrap">
                                    <div class="px-6 py-3">
                        <span class="text-sm text-gray-500 dark:text-neutral-500">
                            {{ \Carbon\Carbon::parse($visitor->created_at)->format('d M, Y') }}
                        </span>
                                    </div>
                                </td>

                                <!-- Actions Dropdown -->
                                <td class="size-px whitespace-nowrap">
                                    <div class="px-6 py-2">
                                        <div class="hs-dropdown [--placement:bottom-right] relative inline-block">
                                            <button
                                                id="hs-table-dropdown-{{ $visitor->id }}"
                                                type="button"
                                                class="hs-dropdown-toggle py-1.5 px-2 inline-flex justify-center items-center gap-2 rounded-lg text-gray-700 dark:text-neutral-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-600 text-sm"
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
                                                class="hs-dropdown-menu transition-[opacity,margin] duration hs-dropdown-open:opacity-100 opacity-0 hidden divide-y divide-gray-200 min-w-40 z-20 bg-white shadow-2xl rounded-lg p-2 mt-2 dark:divide-neutral-700 dark:bg-neutral-800"
                                                role="menu"
                                                aria-orientation="vertical"
                                                aria-labelledby="hs-table-dropdown-{{ $visitor->id }}"
                                            >

                                                <!-- Actions Section -->
                                                <div class="py-2">
                                    <span
                                        class="block py-2 px-3 text-xs font-medium uppercase text-gray-400 dark:text-neutral-600">
                                        Actions
                                    </span>

                                                    {{-- Example Edit link --}}
                                                    <a href="{{ route('visitors.edit', $visitor->id) }}" class="flex items-center gap-x-3 py-2 px-3 rounded-lg text-sm text-gray-800 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 dark:text-neutral-400 dark:hover:bg-neutral-700 dark:hover:text-neutral-300 dark:focus:bg-neutral-700 dark:focus:text-neutral-300">
                                                        Edit
                                                    </a>


                                                    {{-- Timeline link --}}
                                                    <a class="flex items-center gap-x-3 py-2 px-3 rounded-lg text-sm text-gray-800 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 dark:text-neutral-400 dark:hover:bg-neutral-700 dark:hover:text-neutral-300 dark:focus:bg-neutral-700 dark:focus:text-neutral-300"
                                                       href="{{ route('visitors.timeline', $visitor->id) }}">
                                                        View Timeline
                                                    </a>

                                                    @if($visitor->status == 'pending')
                                                        <form action="{{ route('visitors.update', $visitor->id) }}" method="POST" style="display: inline;">
                                                            @csrf
                                                            @method('PATCH')
                                                            <!-- When pending, clicking will change status to 'approved' -->
                                                            <input type="hidden" name="status" value="approved">
                                                            <button type="submit" class="flex items-center gap-x-3 py-2 px-3 rounded-lg text-sm text-gray-800 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 dark:text-neutral-400 dark:hover:bg-neutral-700 dark:hover:text-neutral-300 dark:focus:bg-neutral-700 dark:focus:text-neutral-300">
                                                                Approve
                                                            </button>
                                                        </form>
                                                    @elseif($visitor->status == 'approved')
                                                        <form action="{{ route('visitors.update', $visitor->id) }}" method="POST" style="display: inline;">
                                                            @csrf
                                                            @method('PATCH')
                                                            <!-- When approved, clicking will change status to 'checked_in' -->
                                                            <input type="hidden" name="status" value="checked_in">
                                                            <button type="submit" class="flex items-center gap-x-3 py-2 px-3 rounded-lg text-sm text-gray-800 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 dark:text-neutral-400 dark:hover:bg-neutral-700 dark:hover:text-neutral-300 dark:focus:bg-neutral-700 dark:focus:text-neutral-300">
                                                                Check In
                                                            </button>
                                                        </form>
                                                    @elseif($visitor->status == 'checked_in')
                                                        <form action="{{ route('visitors.update', $visitor->id) }}" method="POST" style="display: inline;">
                                                            @csrf
                                                            @method('PATCH')
                                                            <!-- When checked in, clicking will change status to 'checked_out' -->
                                                            <input type="hidden" name="status" value="checked_out">
                                                            <button type="submit" class="flex items-center gap-x-3 py-2 px-3 rounded-lg text-sm text-gray-800 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 dark:text-neutral-400 dark:hover:bg-neutral-700 dark:hover:text-neutral-300 dark:focus:bg-neutral-700 dark:focus:text-neutral-300">
                                                                Check Out
                                                            </button>
                                                        </form>
                                                    @endif


                                                </div>

                                                <!-- Delete Section -->
                                                <div class="py-2">
                                                    <a class="flex items-center gap-x-3 py-2 px-3 rounded-lg text-sm text-red-600 hover:bg-gray-100 dark:text-red-500 dark:hover:text-neutral-300"
                                                       href="/visitor/{{ $visitor->id }}/delete">
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
                        {{ $visitors->links() }}
                    </x-slot>

                </x-table-footer>
            </x-table-wrapper>
            <!-- End Table Section -->
        </div>
    </div>
</x-app-layout>
