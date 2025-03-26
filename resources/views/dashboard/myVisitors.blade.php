<div class="py-3 flex items-center text-sm text-gray-800 before:flex-1 before:border-t before:border-gray-200 before:me-6 after:flex-1 after:border-t after:border-gray-200 after:ms-6 dark:text-white dark:before:border-neutral-600 dark:after:border-neutral-600">My Visitors</div>

<div class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
    <div class="grid sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-3 sm:gap-6">
        @foreach ($myVisitors as $myVisitor)
            <x-card class="text-gray-100 border border-gray-700 bg-brand-900">
                <div class="flex justify-between items-center gap-x-3">
                    <!-- Left Side: Visitor Details -->
                    <div class="grow">
                        <h3 class="font-semibold text-lg mt-2">
                            {{ $myVisitor->first_name ?? 'Null' }} {{ $myVisitor->last_name ?? 'Null' }}
                        </h3>

                        <!-- Telephone with icon -->
                        <p class="flex items-center text-sm text-gray-400 mt-2">
                            <svg class="mr-1 h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                 viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                 stroke-linecap="round" stroke-linejoin="round">
                                <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07
                        19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1
                        2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6
                        6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>
                            </svg>
                            <span>: {{ $myVisitor->telephone ?? 'Null' }}</span>
                        </p>

                        <!-- Access Code -->
                        <p class="mt-2 text-base font-semibold text-blue-400">
                            Access Code:
                            <span class="inline-block bg-gray-800 text-gray-100 rounded px-2 py-1 ml-1">
                        {{ $myVisitor->visitor_code ?? 'Null' }}
                    </span>
                        </p>
                        <div class="inline-flex items-center gap-x-3">
                            <div id="hs-clipboard-basic" class="text-sm font-medium text-gray-800 dark:text-white">
                                test 2
                            </div>

                            <button type="button" class="js-clipboard-example p-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-2xs hover:bg-gray-50 focus:outline-hidden focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-700 dark:focus:bg-neutral-700" data-clipboard-target="#hs-clipboard-basic" data-clipboard-action="copy" data-clipboard-success-text="Copied">
                                <svg class="js-clipboard-default size-4 group-hover:rotate-6 transition" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect width="8" height="4" x="8" y="2" rx="1" ry="1"></rect>
                                    <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path>
                                </svg>

                                <svg class="js-clipboard-success hidden size-4 text-blue-600" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="20 6 9 17 4 12"></polyline>
                                </svg>
                            </button>
                        </div>
                        <!-- Visit Date with icon -->
                        <p class="flex items-center text-sm text-gray-400 mt-2">
                            <svg class="mr-1 h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                 viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                 stroke-linecap="round" stroke-linejoin="round">
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
                            <svg class="mr-1 h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                 viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                 stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"/>
                                <polyline points="12 6 12 12 16 14"/>
                            </svg>
                            <span>
                        : {{ \Carbon\Carbon::parse($myVisitor->start_time)->format('h:i A') }}
                        - {{ \Carbon\Carbon::parse($myVisitor->end_time)->format('h:i A') }}
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
                            <button
                                id="hs-table-dropdown-{{ $myVisitor->id }}"
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
                                aria-labelledby="hs-table-dropdown-{{ $myVisitor->id }}"
                            >
                                <!-- Actions Section -->
                                <div class="py-2">
                            <span class="block py-2 px-3 text-xs font-medium uppercase text-gray-400 dark:text-neutral-600">
                                Actions
                            </span>

                                    {{-- Example Edit link --}}
                                    <a href="{{ route('visitors.edit', $myVisitor->id) }}"
                                       class="flex items-center gap-x-3 py-2 px-3 rounded-lg text-sm text-gray-800 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 dark:text-neutral-400 dark:hover:bg-neutral-700 dark:hover:text-neutral-300 dark:focus:bg-neutral-700 dark:focus:text-neutral-300">
                                        Edit
                                    </a>

                                    {{-- Timeline link --}}
                                    <a class="flex items-center gap-x-3 py-2 px-3 rounded-lg text-sm text-gray-800 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 dark:text-neutral-400 dark:hover:bg-neutral-700 dark:hover:text-neutral-300 dark:focus:bg-neutral-700 dark:focus:text-neutral-300"
                                       href="{{ route('visitors.timeline', $myVisitor->id) }}">
                                        View Timeline
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </x-card>
        @endforeach

    </div>
    <div class="inline-flex items-center gap-x-3">
        <div id="hs-clipboard-basic" class="text-sm font-medium text-gray-800 dark:text-white">
            test 2
        </div>

        <button type="button" class="js-clipboard-example p-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-2xs hover:bg-gray-50 focus:outline-hidden focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-700 dark:focus:bg-neutral-700" data-clipboard-target="#hs-clipboard-basic" data-clipboard-action="copy" data-clipboard-success-text="Copied">
            <svg class="js-clipboard-default size-4 group-hover:rotate-6 transition" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect width="8" height="4" x="8" y="2" rx="1" ry="1"></rect>
                <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path>
            </svg>

            <svg class="js-clipboard-success hidden size-4 text-blue-600" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="20 6 9 17 4 12"></polyline>
            </svg>
        </button>
    </div>
    <div class="mt-6 flex justify-center">
        {{ $myVisitors->links() }}
    </div>
</div>
