<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <!-- Title on the left -->
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Results') }}
            </h2>
        </div>


    </x-slot>
    <div class="py-12 bg-primary text-white min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <div class="overflow-hidden shadow-sm sm:rounded-lg">
        @can('view-all-visitors')
        <div
            class="py-3 flex items-center text-sm  before:flex-1 before:border-t before:border-gray-200 before:me-6 after:flex-1 after:border-t after:border-gray-200 after:ms-6 text-white dark:before:border-neutral-600 dark:after:border-neutral-600">
            All Visitors
        </div>
        <div class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
            <div class="grid sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-3 sm:gap-6">
                @foreach ($visitors as $allVisitor)

                <x-card class="bg-brand-900 text-gray-100 border border-gray-700 overflow-visible">
                        <div class="flex justify-between items-start gap-x-3">
                            <!-- Main Content -->
                            <div class="grow">
                                <h3 class="font-semibold text-lg">
                                    {{ $allVisitor->first_name ?? 'Null' }} {{ $allVisitor->last_name ?? 'Null' }}
                                </h3>

                                <!-- Phone -->
                                <p class="flex items-center text-sm text-gray-400 mt-2">
                                    <svg
                                        class="mr-1 h-4 w-4 text-gray-400"
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="2"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>
                                    </svg>
                                    <span>: {{ $allVisitor->telephone ?? 'Null' }}</span>
                                </p>

                                <!-- Hosted By -->
                                <p class="flex items-center text-sm text-gray-400 mt-2">
                                    <svg
                                        class="mr-1 h-4 w-4 text-gray-400"
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="2"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        viewBox="0 0 24 24"
                                    >
                                        <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/>
                                        <circle cx="12" cy="7" r="4"/>
                                    </svg>

                                    <span>
        :
        @if($allVisitor->user_id === null)
                                            Walk-In
                                        @else
                                            {{ $allVisitor->user->user_details->school_id ?? 'Unknown' }}
                                        @endif
    </span>
                                </p>

                                <!-- Visit Date -->
                                <p class="flex items-center text-sm text-gray-400 mt-2">
                                    <svg
                                        class="mr-1 h-4 w-4 text-gray-400"
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="2"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        viewBox="0 0 24 24"
                                    >
                                        <path d="M11 14h1v4"/>
                                        <path d="M16 2v4"/>
                                        <path d="M3 10h18"/>
                                        <path d="M8 2v4"/>
                                        <rect x="3" y="4" width="18" height="18" rx="2"/>
                                    </svg>
                                    <span>: {{ \Carbon\Carbon::parse($allVisitor->visit_date)->format('M d') }}</span>
                                </p>

                                <!-- Time Range -->
                                <p class="flex items-center text-sm text-gray-400 mt-2">
                                    <svg
                                        class="mr-1 h-4 w-4 text-gray-400"
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="2"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        viewBox="0 0 24 24"
                                    >
                                        <circle cx="12" cy="12" r="10"/>
                                        <polyline points="12 6 12 12 16 14"/>
                                    </svg>
                                    <span> :
                        {{ \Carbon\Carbon::parse($allVisitor->start_time)->format('h:i A') }}
                        -
                        {{ \Carbon\Carbon::parse($allVisitor->end_time)->format('h:i A') }}
                    </span>
                                </p>

                                <!-- Status Badge -->
                                <p class="mt-2">
                                    <x-status-badge status="{{ $allVisitor->status }}"/>
                                </p>

                                <!-- Status Actions -->
                                <div class="mt-3">
                                    @if($allVisitor->status == 'pending')
                                        @if(auth()->user()?->user_details?->role === 'HR Admin' || auth()->user()?->user_details?->role === 'super admin')
                                            <!-- Approve Form -->
                                            <form action="{{ route('visitors.update', $allVisitor->id) }}" method="POST" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="approved">
                                                <input type="hidden" name="redirect_to" value="{{ route('dashboard') }}">
                                                <div class="hs-tooltip inline-block">
                                                    <button type="submit" title="Approve" class="hs-tooltip-toggle bg-white hover:bg-gray-100 p-2 rounded border border-gray-300">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                                             fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                             stroke-linejoin="round" class="lucide lucide-check-icon lucide-check text-black">
                                                            <path d="M20 6 9 17l-5-5"/>
                                                        </svg>
                                                        <span class="hs-tooltip-content hs-tooltip-shown:opacity-100 hs-tooltip-shown:visible opacity-0 transition-opacity inline-block absolute invisible z-10 py-1 px-2 bg-gray-900 text-xs font-medium text-white rounded-md shadow-2xs dark:bg-neutral-700" role="tooltip">
                                            Approve
                                        </span>
                                                    </button>
                                                </div>
                                            </form>

                                            <!-- Deny Form -->
                                            <form action="{{ route('visitors.update', $allVisitor->id) }}" method="POST" class="inline ml-2">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="denied">
                                                <input type="hidden" name="redirect_to" value="{{ route('dashboard') }}">
                                                <div class="hs-tooltip inline-block">
                                                    <button type="submit" title="Deny" class="hs-tooltip-toggle bg-white hover:bg-gray-100 p-2 rounded border border-gray-300">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                                             fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                             stroke-linejoin="round" class="lucide lucide-x-icon lucide-x text-black">
                                                            <path d="M18 6 6 18"/>
                                                            <path d="m6 6 12 12"/>
                                                        </svg>
                                                        <span class="hs-tooltip-content hs-tooltip-shown:opacity-100 hs-tooltip-shown:visible opacity-0 transition-opacity inline-block absolute invisible z-10 py-1 px-2 bg-gray-900 text-xs font-medium text-white rounded-md shadow-2xs dark:bg-neutral-700" role="tooltip">
                                            Deny
                                        </span>
                                                    </button>
                                                </div>
                                            </form>
                                        @endif
                                    @elseif($allVisitor->status == 'approved')
                                        @include('visitors.partials.checkin_form', ['visitor' => $allVisitor])
                                    @elseif($allVisitor->status == 'checked_in')
                                        <!-- Check-out Form -->
                                        <form action="{{ route('visitors.update', $allVisitor->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="checked_out">
                                            <input type="hidden" name="redirect_to" value="{{ route('dashboard') }}">
                                            <x-primary-button class="bg-gray-700 hover:bg-gray-600 text-white">
                                                Check Out
                                            </x-primary-button>
                                        </form>
                                    @elseif($allVisitor->status == 'denied')
                                        <span class="text-red-400">Visitor denied</span>
                                    @endif
                                </div>
                            </div>

                            <!-- Dropdown Menu -->
                            <div class="flex-shrink-0">
                                <div class="hs-dropdown [--placement:bottom-end] relative inline-flex self-start">
                                    <button
                                        id="hs-table-dropdown-{{ $allVisitor->id }}"
                                        type="button"
                                        class="hs-dropdown-toggle py-1 px-1 inline-flex justify-center items-center gap-2 rounded-lg text-gray-400 hover:text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-600 text-sm"
                                        aria-haspopup="menu"
                                        aria-expanded="false"
                                        aria-label="Dropdown"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-ellipsis-icon lucide-ellipsis"><circle cx="12" cy="12" r="1"/><circle cx="19" cy="12" r="1"/><circle cx="5" cy="12" r="1"/></svg>
                                    </button>

                                    <div
                                        class="hs-dropdown-menu transition-[opacity,margin] duration hs-dropdown-open:opacity-100 opacity-0 hidden min-w-40 z-20 bg-white shadow-2xl rounded-lg p-2 mt-2 dark:bg-neutral-800"
                                        role="menu"
                                        aria-orientation="vertical"
                                        aria-labelledby="hs-table-dropdown-{{ $allVisitor->id }}"
                                    >
                                        <div class="py-2">
                            <span class="block py-2 px-3 text-xs font-medium uppercase text-gray-400 dark:text-neutral-600">
                                Actions
                            </span>
                                            <a
                                                href="{{ route('visitors.edit', $allVisitor->id) }}"
                                                class="flex items-center gap-x-3 py-2 px-3 rounded-lg text-sm text-gray-800 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 dark:text-neutral-400 dark:hover:bg-neutral-700 dark:hover:text-neutral-300"
                                            >
                                                Edit
                                            </a>
                                            <a
                                                class="flex items-center gap-x-3 py-2 px-3 rounded-lg text-sm text-gray-800 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 dark:text-neutral-400 dark:hover:bg-neutral-700 dark:hover:text-neutral-300"
                                                href="{{ route('visitors.timeline', $allVisitor->id) }}"
                                            >
                                                View Timeline
                                            </a>
                                            <a class="flex items-center gap-x-3 py-2 px-3 rounded-lg text-sm text-neutral-200 hover:bg-neutral-700 focus:outline-none focus:bg-neutral-700"
                                               href="{{ route('visitors.show', $allVisitor->id) }}">
                                                View Info
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </x-card>
                @endforeach

            </div>
            <div class="mt-6 flex justify-center">

            </div>
        </div>
        @endcan

        <div class="py-3 flex items-center text-sm  before:flex-1 before:border-t before:border-gray-200 before:me-6 after:flex-1 after:border-t after:border-gray-200 after:ms-6 text-white dark:before:border-neutral-600 dark:after:border-neutral-600">My Visitors</div>

        <div class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
            <div class="grid sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-3 sm:gap-6">
                @foreach ($visitors as $myVisitor)
                <x-card class="text-gray-100 border border-gray-700 bg-brand-900">
                        <div class="flex justify-between items-center gap-x-3">
                            <!-- Left Side: Visitor Details -->
                            <div class="grow">
                                <h3 class="font-semibold text-lg mt-2">
                                    {{ $myVisitor->first_name ?? 'Null' }} {{ $myVisitor->last_name ?? 'Null' }}
                                </h3>

                                <!-- Telephone with icon -->
                                <p class="flex items-center text-sm text-gray-400 mt-2">
                                    <svg class="mr-1 h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                         width="16" height="16" viewBox="0 0 24 24" fill="none"
                                         stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07
                        19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1
                        2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6
                        6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>
                                    </svg>
                                    <span>: {{ $myVisitor->telephone ?? 'Null' }}</span>
                                </p>

                                <!-- Access Code with icon and copy button -->
                                <p class="flex items-center text-sm text-gray-400 mt-2">
                                    <svg class="mr-1 h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                         width="16" height="16" viewBox="0 0 24 24" fill="none"
                                         stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M2.586 17.414A2 2 0 0 0 2 18.828V21a1 1 0 0 0 1 1h3a1 1 0 0 0 1-1v-1a1 1 0 0 1 1-1h1a1 1 0 0 0 1-1v-1a1 1 0 0 1 1-1h.172a2 2 0 0 0 1.414-.586l.814-.814a6.5 6.5 0 1 0-4-4z"/>
                                        <circle cx="16.5" cy="7.5" r=".5" fill="currentColor"/>
                                    </svg>
                                    <span>:</span>
                                    <span id="hs-clipboard-basic" class="ml-2 inline-block font-bold bg-gray-800 text-gray-100 rounded px-2 py-1">
                        {{ $myVisitor->visitor_code ?? 'Null' }}
                    </span>
                                    <button type="button" class="js-clipboard-example ml-2 p-2 inline-flex items-center gap-x-2 rounded-lg border border-gray-200 bg-transparent text-gray-10000 shadow-2xs hover:bg-gray-50 focus:outline-hidden focus:bg-gray-50"
                                            data-clipboard-target="#hs-clipboard-basic" data-clipboard-action="copy" data-clipboard-success-text="Copied">
                                        <svg class="js-clipboard-default size-4 group-hover:rotate-6 transition" xmlns="http://www.w3.org/2000/svg"
                                             width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                             stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <rect width="8" height="4" x="8" y="2" rx="1" ry="1"></rect>
                                            <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path>
                                        </svg>
                                        <svg class="js-clipboard-success hidden size-4 text-blue-600" xmlns="http://www.w3.org/2000/svg"
                                             width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                             stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <polyline points="20 6 9 17 4 12"></polyline>
                                        </svg>
                                    </button>
                                </p>

                                <!-- Visit Date with icon -->
                                <p class="flex items-center text-sm text-gray-400 mt-2">
                                    <svg class="mr-1 h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                         width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                         stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M11 14h1v4"/>
                                        <path d="M16 2v4"/>
                                        <path d="M3 10h18"/>
                                        <path d="M8 2v4"/>
                                        <rect x="3" y="4" width="18" height="18" rx="2"/>
                                    </svg>
                                    <span>: {{ \Carbon\Carbon::parse($myVisitor->visit_date)->format('M d') }}</span>
                                </p>

                                <!-- Time with icon -->
                                <p class="flex items-center text-sm text-gray-400 mt-2">
                                    <svg class="mr-1 h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                         width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                         stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <circle cx="12" cy="12" r="10"/>
                                        <polyline points="12 6 12 12 16 14"/>
                                    </svg>
                                    <span>
                        : {{ \Carbon\Carbon::parse($myVisitor->start_time)->format('h:i A') }} - {{ \Carbon\Carbon::parse($myVisitor->end_time)->format('h:i A') }}
                    </span>
                                </p>

                                <!-- Status Badge -->
                                <p class="mt-2">
                                    <x-status-badge status="{{ $myVisitor->status ?? 'Null' }}"/>
                                </p>
                            </div>

                            <!-- Right Side: Icons Container -->
                            <div class="flex items-center gap-x-2">
                                <div class="hs-dropdown [--placement:bottom-right] relative inline-block">
                                    <button id="hs-table-dropdown-{{ $myVisitor->id }}" type="button"
                                            class="hs-dropdown-toggle py-1.5 px-2 inline-flex justify-center items-center gap-2 rounded-lg text-gray-700 dark:text-neutral-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-600 text-sm"
                                            aria-haspopup="menu" aria-expanded="false" aria-label="Dropdown">
                                        <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg"
                                             width="24" height="24" fill="none" stroke="currentColor" stroke-width="2"
                                             stroke-linecap="round" stroke-linejoin="round">
                                            <circle cx="12" cy="12" r="1"/>
                                            <circle cx="19" cy="12" r="1"/>
                                            <circle cx="5" cy="12" r="1"/>
                                        </svg>
                                    </button>
                                    <div class="hs-dropdown-menu transition-[opacity,margin] duration hs-dropdown-open:opacity-100 opacity-0 hidden divide-y divide-gray-200 min-w-40 z-20 bg-white shadow-2xl rounded-lg p-2 mt-2 dark:divide-neutral-700 dark:bg-neutral-800"
                                         role="menu" aria-orientation="vertical" aria-labelledby="hs-table-dropdown-{{ $myVisitor->id }}">
                                        <!-- Actions Section -->
                                        <div class="py-2">
                            <span class="block py-2 px-3 text-xs font-medium uppercase text-gray-400 dark:text-neutral-600">
                                Actions
                            </span>
                                            @can('update-visitor', $myVisitor)
                                                <a href="{{ route('visitors.edit', $myVisitor->id) }}"
                                                   class="flex items-center gap-x-3 py-2 px-3 rounded-lg text-sm text-gray-800 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 dark:text-neutral-400 dark:hover:bg-neutral-700 dark:hover:text-neutral-300 dark:focus:bg-neutral-700 dark:focus:text-neutral-300">
                                                    Edit
                                                </a>
                                            @endcan

                                            <a class="flex items-center gap-x-3 py-2 px-3 rounded-lg text-sm text-gray-800 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 dark:text-neutral-400 dark:hover:bg-neutral-700 dark:hover:text-neutral-300 dark:focus:bg-neutral-700 dark:focus:text-neutral-300"
                                               href="{{ route('visitors.timeline', $myVisitor->id) }}">
                                                View Timeline
                                            </a>
                                            <a class="flex items-center gap-x-3 py-2 px-3 rounded-lg text-sm text-neutral-200 hover:bg-neutral-700 focus:outline-none focus:bg-neutral-700"
                                               href="{{ route('visitors.show', $myVisitor->id) }}">
                                                View Info
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </x-card>
                @endforeach


            </div>
            <div class="mt-6 flex justify-center">

            </div>
        </div>

    </div>
        </div>
    </div>
</x-app-layout>
