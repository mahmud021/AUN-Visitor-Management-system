<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Search Results') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12 bg-primary text-white min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden shadow-sm sm:rounded-lg">
                <!-- All Visitors Results -->
                @if($allVisitors->isNotEmpty())
                    @can('view-all-visitors')
                    <div class="py-3 flex items-center text-sm before:flex-1 before:border-t before:border-gray-200 before:me-6 after:flex-1 after:border-t after:border-gray-200 after:ms-6 text-white">
                        All Visitors
                    </div>

                    <div class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
                        <div class="grid gap-6 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4">
                            @foreach($allVisitors as $visitor)
                                <x-card class="pt-6 bg-brand-900 border border-gray-700">
                                    <div class="absolute top-4 right-4">
                                        <x-status-badge :status="$visitor->status" />
                                    </div>

                                    <h3 class="text-lg font-bold tracking-tight mt-6">
                                        {{ $visitor->first_name }} {{ $visitor->last_name }}
                                    </h3>

                                    <dl class="space-y-1.5 text-sm text-neutral-400">
                                        <!-- Telephone -->
                                        <div class="grid grid-cols-[auto_1fr] items-center gap-x-2">
                                            <svg class="size-4 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <!-- Phone icon -->
                                            </svg>
                                            <dd>{{ $visitor->telephone ?? '—' }}</dd>
                                        </div>

                                        <!-- Host/Walk-in -->
                                        <div class="grid grid-cols-[auto_1fr] items-center gap-x-2">
                                            <svg class="size-4 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <!-- User icon -->
                                            </svg>
                                            <dd>
                                                @if($visitor->user_id === null)
                                                    Walk-In
                                                @else
                                                    {{ $visitor->user->user_details->school_id ?? 'Unknown' }}
                                                @endif
                                            </dd>
                                        </div>

                                        <!-- Date/Time -->
                                        <div class="grid grid-cols-[auto_1fr] items-center gap-x-2">
                                            <svg class="size-4 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <!-- Calendar icon -->
                                            </svg>
                                            <dd>{{ \Carbon\Carbon::parse($visitor->visit_date)->format('M d') }}</dd>
                                        </div>

                                        <!-- Time Range -->
                                        <div class="grid grid-cols-[auto_1fr] items-center gap-x-2">
                                            <svg class="size-4 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <!-- Clock icon -->
                                            </svg>
                                            <dd>
                                                {{ \Carbon\Carbon::parse($visitor->start_time)->format('h:i A') }} –
                                                {{ \Carbon\Carbon::parse($visitor->end_time)->format('h:i A') }}
                                            </dd>
                                        </div>
                                    </dl>

                                    <!-- Actions -->
                                    <div class="mt-auto flex items-center gap-2">
                                        @if($visitor->status == 'pending')
                                            @can('override-visitor-creation')
                                                <!-- Approve Button -->
                                                <form action="{{ route('visitors.approve', $visitor) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('PATCH')
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

                                                <!-- Deny Button -->
                                                <form action="{{ route('visitors.deny', $visitor) }}" method="POST" class="inline ml-2">
                                                    @csrf
                                                    @method('PATCH')
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
                                            @endcan

                                        @elseif($visitor->status == 'approved')
                                            @include('visitors.partials.checkin_form', ['visitor' => $visitor])

                                        @elseif($visitor->status == 'checked_in')
                                            <!-- Check-out Button -->
                                            <form action="{{ route('visitors.checkout', $visitor) }}" method="POST" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <x-primary-button class="bg-gray-700 hover:bg-gray-600 text-white">
                                                    Check Out
                                                </x-primary-button>
                                            </form>

                                        @elseif($visitor->status == 'denied')
                                            <span class="text-red-400">Visitor denied</span>
                                        @endif
                                    </div>


                                    <!-- Dropdown Menu -->
                                    <div class="mt-2 flex justify-end">
                                        <x-dropdown align="right" width="48">
                                            {{-- Trigger (3-dot icon) --}}
                                            <x-slot name="trigger">
                                                <button class="p-1.5 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-full transition-colors"
                                                        type="button"
                                                        aria-label="Actions">
                                                    <svg class="w-5 h-5 text-gray-500 dark:text-gray-300" fill="currentColor"
                                                         viewBox="0 0 20 20">
                                                        <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z"/>
                                                    </svg>
                                                </button>
                                            </x-slot>

                                            {{-- Dropdown Content --}}
                                            <x-slot name="content">
                                                @can('update-visitor', $visitor)
                                                    <a href="{{ route('visitors.edit', $visitor->id) }}"
                                                       class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800">
                                                        Edit
                                                    </a>
                                                @endcan

                                                <a href="{{ route('visitors.timeline', $visitor->id) }}"
                                                   class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800">
                                                    View timeline
                                                </a>

                                                <a href="{{ route('visitors.show', $visitor->id) }}"
                                                   class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800">
                                                    View info
                                                </a>
                                            </x-slot>
                                        </x-dropdown>

                                    </div>
                                </x-card>
                            @endforeach
                        </div>
                    </div>
                @endcan
                @endif

                @if($myVisitors->isNotEmpty())
                <div class="py-3 flex items-center text-sm before:flex-1 before:border-t before:border-gray-200 before:me-6 after:flex-1 after:border-t after:border-gray-200 after:ms-6 text-white">
                    My Visitors
                </div>


                <div class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
                    <div class="grid gap-6 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4">
                        @foreach($myVisitors as $visitor)
                            <x-card class="pt-6"> {{-- add padding-top to the whole card --}}
                                <div class="absolute top-4 right-4">
                                    <x-status-badge :status="$visitor->status" />
                                </div>

                                <h3 class="text-lg font-bold tracking-tight mt-6">
                                    {{ $visitor->first_name }} {{ $visitor->last_name }}
                                </h3>

                                {{-- META block … --}}
                                <dl class="space-y-1.5 text-sm text-neutral-400">

                                    {{-- PHONE --}}
                                    <div class="flex items-center gap-x-1">
                                        <svg class="size-4 shrink-0" xmlns="http://www.w3.org/2000/svg"
                                             viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                             stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M22 16.92v3a2 2 0 0 1-2.18 2
                       19.79 19.79 0 0 1-8.63-3.07
                       19.5 19.5 0 0 1-6-6
                       19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2
                       2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81
                       2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27
                       a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7
                       A2 2 0 0 1 22 16.92z"/>
                                        </svg>
                                        <dd>{{ $visitor->telephone ?? 'Null' }}</dd>
                                    </div>

                                    {{-- ACCESS-CODE + COPY BTN --}}
                                    <div class="flex items-center gap-x-1">
                                        <svg class="mr-1 h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                             width="16" height="16" viewBox="0 0 24 24" fill="none"
                                             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M2.586 17.414A2 2 0 0 0 2 18.828V21a1 1 0 0 0 1 1h3a1 1 0 0 0 1-1v-1a1 1 0 0 1 1-1h1a1 1 0 0 0 1-1v-1a1 1 0 0 1 1-1h.172a2 2 0 0 0 1.414-.586l.814-.814a6.5 6.5 0 1 0-4-4z"/>
                                            <circle cx="16.5" cy="7.5" r=".5" fill="currentColor"/>
                                        </svg>

                                        <code id="code-{{ $visitor->id }}"
                                              class="px-1.5 py-0.5 rounded bg-neutral-800/70 font-mono text-xs">
                                            {{ $visitor->visitor_code ?? '----' }}
                                        </code>

                                        <button class="ml-2 h-8 w-8 grid place-content-center rounded-lg
                           ring-1 ring-neutral-700/50 hover:ring-blue-600 transition
                           js-clipboard-example"
                                                data-clipboard-target="#code-{{ $visitor->id }}"
                                                aria-label="Copy access code">
                                            {{-- default icon --}}
                                            <svg class="size-4 js-clipboard-default transition group-hover:rotate-6"
                                                 xmlns="http://www.w3.org/2000/svg" fill="none"
                                                 viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <rect width="8" height="4" x="8" y="2" rx="1"/>
                                                <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6
                         a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/>
                                            </svg>
                                            {{-- success icon --}}
                                            <svg class="size-4 js-clipboard-success hidden text-blue-600"
                                                 xmlns="http://www.w3.org/2000/svg" fill="none"
                                                 viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <polyline points="20 6 9 17 4 12"/>
                                            </svg>
                                        </button>
                                    </div>

                                    {{-- DATE --}}
                                    <div class="flex items-center gap-x-1">
                                        <svg class="size-4 shrink-0" xmlns="http://www.w3.org/2000/svg"
                                             viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                             stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M8 2v4M16 2v4M3 10h18"/>
                                            <rect x="3" y="4" width="18" height="18" rx="2"/>
                                        </svg>
                                        <dd>{{ \Carbon\Carbon::parse($visitor->visit_date)->format('M d') }}</dd>
                                    </div>

                                    {{-- TIME RANGE --}}
                                    <div class="flex items-center gap-x-1">
                                        <svg class="size-4 shrink-0" xmlns="http://www.w3.org/2000/svg"
                                             viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                             stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <circle cx="12" cy="12" r="10"/>
                                            <polyline points="12 6 12 12 16 14"/>
                                        </svg>
                                        <dd>
                                            {{ \Carbon\Carbon::parse($visitor->start_time)->format('h:i A') }} –
                                            {{ \Carbon\Carbon::parse($visitor->end_time)->format('h:i A') }}
                                        </dd>
                                    </div>
                                </dl>

                                {{-- ACTIONS DROPDOWN ───────────────────────────────────────────--}}
                                <div class="mt-auto flex justify-end">
                                    <x-dropdown align="right" width="48">
                                        {{-- Trigger (3-dot icon) --}}
                                        <x-slot name="trigger">
                                            <button class="p-1.5 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-full transition-colors"
                                                    type="button"
                                                    aria-label="Actions">
                                                <svg class="w-5 h-5 text-gray-500 dark:text-gray-300" fill="currentColor"
                                                     viewBox="0 0 20 20">
                                                    <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z"/>
                                                </svg>
                                            </button>
                                        </x-slot>

                                        {{-- Dropdown Content --}}
                                        <x-slot name="content">
                                            @can('update-visitor', $visitor)
                                                <a href="{{ route('visitors.edit', $visitor->id) }}"
                                                   class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800">
                                                    Edit
                                                </a>
                                            @endcan

                                            <a href="{{ route('visitors.timeline', $visitor->id) }}"
                                               class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800">
                                                View timeline
                                            </a>

                                            <a href="{{ route('visitors.show', $visitor->id) }}"
                                               class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800">
                                                View info
                                            </a>
                                        </x-slot>
                                    </x-dropdown>
                                </div>
                            </x-card>
                        @endforeach
                    </div>

                </div>
                @endif
                <!-- Empty State -->
                @if($allVisitors->isEmpty() && $myVisitors->isEmpty())
                    <div class="text-center py-12 text-gray-300">
                        No visitors found matching "{{ request('q') }}"
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
