<h3 class="font-semibold text-lg">
    My Visitors
</h3>
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
                        <p class="text-sm text-gray-400 mt-2">
                            Telephone: {{ $myVisitor->telephone ?? 'Null' }}
                        </p>
                        <p class="mt-2 text-base font-semibold text-blue-400">
                            Access Code:
                            <span class="inline-block bg-gray-800 text-gray-100 rounded px-2 py-1 ml-1">
                                {{ $myVisitor->visitor_code ?? 'Null' }}
                            </span>
                        </p>
                        <p class="text-sm text-gray-400 mt-2">
                            Visit Date: {{ \Carbon\Carbon::parse($myVisitor->visit_date)->format('M d') }}
                        </p>
                        <p class="text-sm text-gray-400 mt-2">
                            Time: {{ \Carbon\Carbon::parse($myVisitor->start_time)->format('h:i A') }}
                            - {{ \Carbon\Carbon::parse($myVisitor->end_time)->format('h:i A') }}
                        </p>
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
                                    <span
                                        class="block py-2 px-3 text-xs font-medium uppercase text-gray-400 dark:text-neutral-600">
                                        Actions
                                    </span>

                                    {{-- Example Edit link --}}
                                    <a href="{{ route('visitors.edit', $myVisitor->id) }}" class="flex items-center gap-x-3 py-2 px-3 rounded-lg text-sm text-gray-800 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 dark:text-neutral-400 dark:hover:bg-neutral-700 dark:hover:text-neutral-300 dark:focus:bg-neutral-700 dark:focus:text-neutral-300">
                                        Edit
                                    </a>

                                    {{-- Timeline link --}}
                                    <a class="flex items-center gap-x-3 py-2 px-3 rounded-lg text-sm text-gray-800 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 dark:text-neutral-400 dark:hover:bg-neutral-700 dark:hover:text-neutral-300 dark:focus:bg-neutral-700 dark:focus:text-neutral-300"
                                       href="{{ route('visitors.timeline', $myVisitor->id) }}">
                                        View Timeline
                                    </a>

                                </div>

                                <!-- Delete Section -->
{{--                                <div class="py-2">--}}
{{--                                    <a class="flex items-center gap-x-3 py-2 px-3 rounded-lg text-sm text-red-600 hover:bg-gray-100 dark:text-red-500 dark:hover:text-neutral-300"--}}
{{--                                       href="/visitor/{{ $myVisitor->id }}/delete">--}}
{{--                                        Delete--}}
{{--                                    </a>--}}
{{--                                </div>--}}
                                <!-- End Delete Section -->
                            </div>
                        </div>
                    </div>
                </div>
            </x-card>
        @endforeach
    </div>
    <div class="mt-6 flex justify-center">
        {{ $myVisitors->links() }}
    </div>
</div>
