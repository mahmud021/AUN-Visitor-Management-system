<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-200 leading-tight">
            {{ __('User Information and Logs') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="flex justify-center">
                <div
                    class="flex rounded-lg transition p-1 bg-neutral-800"
                >
                    <nav class="flex justify-center gap-x-1" aria-label="Tabs" role="tablist" aria-orientation="horizontal">
                        <button
                            type="button"
                            class="
        hs-tab-active:bg-neutral-700
        hs-tab-active:text-neutral-100
        py-3 px-4
        inline-flex items-center gap-x-2
        bg-transparent
        text-sm
        text-neutral-400
        hover:text-neutral-200
        focus:outline-none
        font-medium
        rounded-lg
        disabled:opacity-50
        disabled:pointer-events-none
        active
      "
                            id="segment-item-1"
                            aria-selected="true"
                            data-hs-tab="#segment-1"
                            aria-controls="segment-1"
                            role="tab"
                        >
                            Personal Information
                        </button>

                        <button
                            type="button"
                            class="
        hs-tab-active:bg-neutral-700
        hs-tab-active:text-neutral-100
        py-3 px-4
        inline-flex items-center gap-x-2
        bg-transparent
        text-sm
        text-neutral-400
        hover:text-neutral-200
        focus:outline-none
        font-medium
        rounded-lg
        disabled:opacity-50
        disabled:pointer-events-none
      "
                            id="segment-item-2"
                            aria-selected="false"
                            data-hs-tab="#segment-2"
                            aria-controls="segment-2"
                            role="tab"
                        >
                            Visitor Logs
                        </button>

                        <button
                            type="button"
                            class="
        hs-tab-active:bg-neutral-700
        hs-tab-active:text-neutral-100
        py-3 px-4
        inline-flex items-center gap-x-2
        bg-transparent
        text-sm
        text-neutral-400
        hover:text-neutral-200
        focus:outline-none
        font-medium
        rounded-lg
        disabled:opacity-50
        disabled:pointer-events-none
      "
                            id="segment-item-3"
                            aria-selected="false"
                            data-hs-tab="#segment-3"
                            aria-controls="segment-3"
                            role="tab"
                        >
                            Inventory Logs
                        </button>
                    </nav>
                </div>

            </div>

            <div class="mt-3">
                <div id="segment-1" role="tabpanel" aria-labelledby="segment-item-1">
                    <div>
                        <div class="px-4 sm:px-0">
                            <h3 class="text-base/7 font-semibold text-brand-50"></h3>
                            <p class="mt-1 max-w-2xl text-sm/6 text-brand-300">Personal details.</p>
                        </div>
                        <div class="mt-6 border-t border-brand-800 ">
                            <dl class="divide-y divide-brand-800">
                                <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                    <dt class="text-sm/6 font-medium text-brand-50">Full name</dt>
                                    <dd class="mt-1 text-sm/6 text-brand-200 sm:col-span-2 sm:mt-0">{{$user->first_name}} {{$user->last_name}}</dd>
                                </div>
                                <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                    <dt class="text-sm/6 font-medium text-brand-50">Email address</dt>
                                    <dd class="mt-1 text-sm/6 text-brand-200 sm:col-span-2 sm:mt-0">{{$user->email}}</dd>
                                </div>
                                <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                    <dt class="text-sm/6 font-medium text-brand-50">School ID</dt>
                                    <dd class="mt-1 text-sm/6 text-brand-200 sm:col-span-2 sm:mt-0">{{$user->user_details->school_id}}</dd>
                                </div>

                                <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                    <dt class="text-sm/6 font-medium text-brand-50">Role</dt>
                                    <dd class="mt-1 text-sm/6 text-brand-200 sm:col-span-2 sm:mt-0">{{$user->user_details->role}}</dd>
                                </div>
                                <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                    <dt class="text-sm/6 font-medium text-brand-50">Telephone</dt>
                                    <dd class="mt-1 text-sm/6 text-brand-200 sm:col-span-2 sm:mt-0">{{$user->user_details->telephone}}</dd>
                                </div>
                                <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                    <!-- Blacklist status -->
                                    <dt class="text-sm/6 font-medium text-brand-50">Blacklist status</dt>
                                    <dd class="mt-1 text-sm/6 text-brand-200 sm:col-span-2 sm:mt-0">
                                        @if($user->user_details && $user->user_details->blacklist)
                                            <!-- If the user is blacklisted, show an "x" icon -->
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                 viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                 stroke-linecap="round" stroke-linejoin="round"
                                                 class="lucide lucide-x-icon">
                                                <line x1="18" y1="6" x2="6" y2="18"/>
                                                <line x1="6" y1="6" x2="18" y2="18"/>
                                            </svg>
                                        @else
                                            <!-- Otherwise, show a tick icon -->
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                 viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                 stroke-linecap="round" stroke-linejoin="round"
                                                 class="lucide lucide-check-icon">
                                                <path d="M20 6 9 17l-5-5"/>
                                            </svg>
                                        @endif
                                    </dd>

                                    <!-- Bypass HR Approval -->
                                    <dt class="text-sm/6 font-medium text-brand-50">Bypass HR Approval</dt>
                                    <dd class="mt-1 text-sm/6 text-brand-200 sm:col-span-2 sm:mt-0">
                                        @if($user->user_details && $user->user_details->bypass_hr_approval)
                                            <!-- If the user has bypass HR approval enabled, show a tick icon -->
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                 viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                 stroke-linecap="round" stroke-linejoin="round"
                                                 class="lucide lucide-check-icon">
                                                <path d="M20 6 9 17l-5-5"/>
                                            </svg>
                                        @else
                                            <!-- Otherwise, show an "x" icon -->
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                 viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                 stroke-linecap="round" stroke-linejoin="round"
                                                 class="lucide lucide-x-icon">
                                                <line x1="18" y1="6" x2="6" y2="18"/>
                                                <line x1="6" y1="6" x2="18" y2="18"/>
                                            </svg>
                                        @endif
                                    </dd>
                                </div>

                                <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">


                                </div>

                            </dl>
                        </div>
                    </div>

                </div>
                <div id="segment-2" class="hidden" role="tabpanel" aria-labelledby="segment-item-2">
                    <x-table-wrapper>
                        <x-table-header
                            title=""
                            description="Here are the visitors for this user."
                        >
                            <x-slot name="actions">
                                <!-- If you want any actions like "Add new visitor" for this user -->
                            </x-slot>
                        </x-table-header>

                        <x-table>
                            <x-slot name="header">
                                <tr>
                                    <!-- Visitor Name -->
                                    <th scope="col" class="px-6 py-3 text-start">
                                        <div class="flex items-center gap-x-2">
                        <span class="text-xs font-semibold uppercase tracking-wide text-white">
                            Visitor Name
                        </span>
                                        </div>
                                    </th>

                                    <!-- Telephone -->
                                    <th scope="col" class="px-6 py-3 text-start">
                                        <div class="flex items-center gap-x-2">
                        <span class="text-xs font-semibold uppercase tracking-wide text-white">
                            Telephone
                        </span>
                                        </div>
                                    </th>

                                    <!-- Visit Date -->
                                    <th scope="col" class="px-6 py-3 text-start">
                                        <div class="flex items-center gap-x-2">
                        <span class="text-xs font-semibold uppercase tracking-wide text-white">
                            Visit Date
                        </span>
                                        </div>
                                    </th>

                                    <!-- Start Time -->
                                    <th scope="col" class="px-6 py-3 text-start">
                                        <div class="flex items-center gap-x-2">
                        <span class="text-xs font-semibold uppercase tracking-wide text-white">
                            Start Time
                        </span>
                                        </div>
                                    </th>

                                    <!-- End Time -->
                                    <th scope="col" class="px-6 py-3 text-start">
                                        <div class="flex items-center gap-x-2">
                        <span class="text-xs font-semibold uppercase tracking-wide text-white">
                            End Time
                        </span>
                                        </div>
                                    </th>

                                    <!-- Status -->
                                    <th scope="col" class="px-6 py-3 text-start">
                                        <div class="flex items-center gap-x-2">
                        <span class="text-xs font-semibold uppercase tracking-wide text-white">
                            Status
                        </span>
                                        </div>
                                    </th>

                                    <!-- Created At -->
                                    <th scope="col" class="px-6 py-3 text-start">
                                        <div class="flex items-center gap-x-2">
                        <span class="text-xs font-semibold uppercase tracking-wide text-white">
                            Created
                        </span>
                                        </div>
                                    </th>

                                    <!-- Actions Column -->
                                    <th scope="col" class="px-6 py-3 text-end">
                                        <!-- Optional: Actions header -->
                                    </th>
                                </tr>
                            </x-slot>

                            <x-slot name="rows">
                                @foreach ($visitors as $visitor)
                                    <x-table-row>
                                        <!-- Visitor Name -->
                                        <td class="px-6 py-3 whitespace-nowrap">
                        <span class="block text-sm font-semibold text-white">
                            {{ $visitor->first_name }} {{ $visitor->last_name }}
                        </span>
                                        </td>

                                        <!-- Telephone -->
                                        <td class="px-6 py-3 whitespace-nowrap">
                        <span class="block text-sm font-semibold text-white">
                            {{ $visitor->telephone }}
                        </span>
                                        </td>

                                        <!-- Visit Date -->
                                        <td class="px-6 py-3 whitespace-nowrap">
                                            @if($visitor->visit_date)
                                                <span class="block text-sm font-semibold text-white">
                                {{ \Carbon\Carbon::parse($visitor->visit_date)->format('d M, Y') }}
                            </span>
                                            @else
                                                <span class="block text-sm font-semibold text-white">N/A</span>
                                            @endif
                                        </td>

                                        <!-- Start Time -->
                                        <td class="px-6 py-3 whitespace-nowrap">
                                            @if($visitor->start_time)
                                                <span class="block text-sm font-semibold text-white">
                                {{ \Carbon\Carbon::parse($visitor->start_time)->format('g:i A') }}
                            </span>
                                            @else
                                                <span class="block text-sm font-semibold text-white">N/A</span>
                                            @endif
                                        </td>

                                        <!-- End Time -->
                                        <td class="px-6 py-3 whitespace-nowrap">
                                            @if($visitor->end_time)
                                                <span class="block text-sm font-semibold text-white">
                                {{ \Carbon\Carbon::parse($visitor->end_time)->format('g:i A') }}
                            </span>
                                            @else
                                                <span class="block text-sm font-semibold text-white">N/A</span>
                                            @endif
                                        </td>

                                        <!-- Status -->
                                        <td class="px-6 py-3 whitespace-nowrap">
                        <span class="block text-sm font-semibold text-white">
                            <x-status-badge status="{{ $visitor->status ?? 'Null' }}" />
                        </span>
                                        </td>

                                        <!-- Created At -->
                                        <td class="px-6 py-3 whitespace-nowrap">
                        <span class="block text-sm text-white">
                            {{ \Carbon\Carbon::parse($visitor->created_at)->format('d M, Y') }}
                        </span>
                                        </td>

                                        <!-- Actions Column -->
                                        <td class="size-px whitespace-nowrap">
                                            <div class="px-6 py-2">
                                                <div class="hs-dropdown relative inline-block">
                                                    <button
                                                        id="hs-table-dropdown-{{ $user->id }}"
                                                        type="button"
                                                        class="hs-dropdown-toggle py-1.5 px-2 inline-flex justify-center items-center gap-2 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-600 text-sm"
                                                        aria-haspopup="menu"
                                                        aria-expanded="false"
                                                        aria-label="Dropdown"
                                                    >
                                                        <svg
                                                            class="shrink-0 size-4"
                                                            xmlns="http://www.w3.org/2000/svg"
                                                            width="24"
                                                            height="24"
                                                            fill="none"
                                                            stroke="currentColor"
                                                            stroke-width="2"
                                                            stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                        >
                                                            <circle cx="12" cy="12" r="1"/>
                                                            <circle cx="19" cy="12" r="1"/>
                                                            <circle cx="5" cy="12" r="1"/>
                                                        </svg>
                                                    </button>
                                                    <div
                                                        class="hs-dropdown-menu transition-[opacity,margin] duration hs-dropdown-open:opacity-100 opacity-0 hidden divide-y min-w-40 z-20 bg-neutral-800 shadow-2xl rounded-lg p-2 mt-2 border border-neutral-700"
                                                        role="menu"
                                                        aria-orientation="vertical"
                                                        aria-labelledby="hs-table-dropdown-1"
                                                    >
                                                        <div class="py-2 first:pt-0 last:pb-0">
                                        <span class="block py-2 px-3 text-xs font-medium uppercase text-white">
                                            Actions
                                        </span>
                                                            <a
                                                                href="{{ route('visitors.edit', $visitor->id) }}"
                                                                class="flex items-center gap-x-3 py-2 px-3 rounded-lg text-sm text-white hover:bg-neutral-700 focus:outline-none focus:bg-neutral-700"
                                                            >
                                                                Edit
                                                            </a>
                                                            <a
                                                                class="flex items-center gap-x-3 py-2 px-3 rounded-lg text-sm text-white hover:bg-neutral-700 focus:outline-none focus:bg-neutral-700"
                                                                href="{{ route('visitors.timeline', $visitor->id) }}"
                                                            >
                                                                View Timeline
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </x-table-row>
                                @endforeach
                            </x-slot>
                        </x-table>

                        <x-table-footer totalResults="">
                            <x-slot name="pagination">
                                <!-- Add pagination if needed -->
                                {{ $visitors->links() }}
                            </x-slot>
                        </x-table-footer>
                    </x-table-wrapper>

                </div>
                <div id="segment-3" class="hidden" role="tabpanel" aria-labelledby="segment-item-3">
                    <x-table-wrapper>
                        <x-table-header
                            title=""
                            description="List of appliances in inventory."
                        >
                            <x-slot name="actions">
                                <!-- Optional: Add an action like "Add new appliance" -->
                            </x-slot>
                        </x-table-header>

                        <x-table>
                            <x-slot name="header">
                                <tr>
                                    <!-- Appliance Name -->
                                    <th scope="col" class="px-6 py-3 text-left">
                    <span class="text-xs font-semibold uppercase tracking-wide text-white">
                        Appliance Name
                    </span>
                                    </th>
                                    <!-- Brand -->
                                    <th scope="col" class="px-6 py-3 text-left">
                    <span class="text-xs font-semibold uppercase tracking-wide text-white">
                        Brand
                    </span>
                                    </th>
                                    <!-- Location -->
                                    <th scope="col" class="px-6 py-3 text-left">
                    <span class="text-xs font-semibold uppercase tracking-wide text-white">
                        Location
                    </span>
                                    </th>
                                    <!-- Status -->
                                    <th scope="col" class="px-6 py-3 text-left">
                    <span class="text-xs font-semibold uppercase tracking-wide text-white">
                        Status
                    </span>
                                    </th>
                                    <!-- Created At -->
                                    <th scope="col" class="px-6 py-3 text-left">
                    <span class="text-xs font-semibold uppercase tracking-wide text-white">
                        Created At
                    </span>
                                    </th>
                                    <!-- Actions Column -->
                                    <th scope="col" class="px-6 py-3 text-right">
                                        <!-- Optional: Actions header -->
                                    </th>
                                </tr>
                            </x-slot>

                            <x-slot name="rows">
                                @foreach($inventoryItems as $item)
                                    <x-table-row>
                                        <!-- Appliance Name -->
                                        <td class="px-6 py-3 whitespace-nowrap text-sm font-medium text-white">
                                            {{ $item->appliance_name }}
                                        </td>
                                        <!-- Brand -->
                                        <td class="px-6 py-3 whitespace-nowrap text-sm text-white">
                                            {{ $item->brand }}
                                        </td>
                                        <!-- Location -->
                                        <td class="px-6 py-3 whitespace-nowrap text-sm text-white">
                                            {{ $item->location ?? 'N/A' }}
                                        </td>
                                        <!-- Status -->
                                        <td class="px-6 py-3 whitespace-nowrap text-sm text-white">
                                            <x-status-badge status="{{ $item->status }}" />
                                        </td>
                                        <!-- Created At -->
                                        <td class="px-6 py-3 whitespace-nowrap text-sm text-white">
                                            {{ \Carbon\Carbon::parse($item->created_at)->format('d M, Y') }}
                                        </td>
                                        <!-- Actions Column -->
                                        <td class="size-px whitespace-nowrap">
                                            <div class="px-6 py-2">
                                                <div class="hs-dropdown relative inline-block">
                                                    <button
                                                        id="hs-table-dropdown-{{ $user->id }}"
                                                        type="button"
                                                        class="hs-dropdown-toggle py-1.5 px-2 inline-flex justify-center items-center gap-2 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-600 text-sm"
                                                        aria-haspopup="menu"
                                                        aria-expanded="false"
                                                        aria-label="Dropdown"
                                                    >
                                                        <svg
                                                            class="shrink-0 size-4"
                                                            xmlns="http://www.w3.org/2000/svg"
                                                            width="24"
                                                            height="24"
                                                            fill="none"
                                                            stroke="currentColor"
                                                            stroke-width="2"
                                                            stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                        >
                                                            <circle cx="12" cy="12" r="1"/>
                                                            <circle cx="19" cy="12" r="1"/>
                                                            <circle cx="5" cy="12" r="1"/>
                                                        </svg>
                                                    </button>
                                                    <div
                                                        class="hs-dropdown-menu transition-[opacity,margin] duration hs-dropdown-open:opacity-100 opacity-0 hidden divide-y min-w-40 z-20 bg-neutral-800 shadow-2xl rounded-lg p-2 mt-2 border border-neutral-700"
                                                        role="menu"
                                                        aria-orientation="vertical"
                                                        aria-labelledby="hs-table-dropdown-1"
                                                    >
                                                        <div class="py-2 first:pt-0 last:pb-0">
                                        <span class="block py-2 px-3 text-xs font-medium uppercase text-white">
                                            Actions
                                        </span>
                                                            <a
                                                                href=""
                                                                class="flex items-center gap-x-3 py-2 px-3 rounded-lg text-sm text-white hover:bg-neutral-700 focus:outline-none focus:bg-neutral-700"
                                                            >
                                                                Edit
                                                            </a>
                                                            <a
                                                                class="flex items-center gap-x-3 py-2 px-3 rounded-lg text-sm text-white hover:bg-neutral-700 focus:outline-none focus:bg-neutral-700"
                                                                href=""
                                                            >
                                                                View Timeline
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </x-table-row>
                                @endforeach
                            </x-slot>
                        </x-table>

                        <x-table-footer totalResults="">
                            <x-slot name="pagination">
                                <!-- Add pagination if needed -->
                                {{ $inventoryItems->links() }}
                            </x-slot>
                        </x-table-footer>
                    </x-table-wrapper>


                </div>
            </div>


        </div>
    </div>

</x-app-layout>
