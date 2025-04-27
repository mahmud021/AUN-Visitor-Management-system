{{-- ─────────────────────────────────────────────────────────────────────
│  My Visitors grid
└─────────────────────────────────────────────────────────────────── --}}
<div class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
    <div class="grid gap-6 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4">
        @foreach ($myVisitors as $v)
            <x-card>
                {{-- floating STATUS badge --}}
                <div class="absolute top-4 right-4">
                    <x-status-badge :status="$v->status" />
                </div>

                {{-- NAME --}}
                <h3 class="text-lg font-bold tracking-tight">
                    {{ $v->first_name ?? 'Null' }} {{ $v->last_name ?? '' }}
                </h3>

                {{-- META block ───────────────────────────────────────────────--}}
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
                        <dd>{{ $v->telephone ?? 'Null' }}</dd>
                    </div>

                    {{-- ACCESS-CODE + COPY BTN --}}
                    <div class="flex items-center gap-x-1">
                        <svg class="mr-1 h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                             width="16" height="16" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M2.586 17.414A2 2 0 0 0 2 18.828V21a1 1 0 0 0 1 1h3a1 1 0 0 0 1-1v-1a1 1 0 0 1 1-1h1a1 1 0 0 0 1-1v-1a1 1 0 0 1 1-1h.172a2 2 0 0 0 1.414-.586l.814-.814a6.5 6.5 0 1 0-4-4z"/>
                            <circle cx="16.5" cy="7.5" r=".5" fill="currentColor"/>
                        </svg>

                        <code id="code-{{ $v->id }}"
                              class="px-1.5 py-0.5 rounded bg-neutral-800/70 font-mono text-xs">
                            {{ $v->visitor_code ?? '----' }}
                        </code>

                        <button class="ml-2 h-8 w-8 grid place-content-center rounded-lg
                           ring-1 ring-neutral-700/50 hover:ring-blue-600 transition
                           js-clipboard-example"
                                data-clipboard-target="#code-{{ $v->id }}"
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
                        <dd>{{ \Carbon\Carbon::parse($v->visit_date)->format('M d') }}</dd>
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
                            {{ \Carbon\Carbon::parse($v->start_time)->format('h:i A') }} –
                            {{ \Carbon\Carbon::parse($v->end_time)->format('h:i A') }}
                        </dd>
                    </div>
                </dl>

                {{-- ACTIONS DROPDOWN ───────────────────────────────────────────--}}
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
                            @can('update-visitor', $v)
                                <a href="{{ route('visitors.edit', $v->id) }}"
                                   class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800">
                                    Edit
                                </a>
                            @endcan

                            <a href="{{ route('visitors.timeline', $v->id) }}"
                               class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800">
                                View timeline
                            </a>

                            <a href="{{ route('visitors.show', $v->id) }}"
                               class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800">
                                View info
                            </a>
                        </x-slot>
                    </x-dropdown>
                </div>
            </x-card>
        @endforeach
    </div>

    {{-- pagination --}}
    <div class="mt-8 flex justify-center">
        {{ $myVisitors->links() }}
    </div>
</div>
