{{-- ───────────────────────────────────────────────────────────────
│  All Visitors grid
└────────────────────────────────────────────────────────────── --}}
<div class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
    <div class="grid gap-6 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4">
        @foreach ($allVisitors as $v)
            <x-card>
                {{-- floating STATUS badge --}}
                <div class="absolute top-4 right-4">
                    <x-status-badge :status="$v->status" />
                </div>

                {{-- NAME --}}
                <h3 class="text-lg font-bold tracking-tight">
                    {{ $v->first_name ?? 'Null' }} {{ $v->last_name ?? '' }}
                </h3>

                {{-- META block --}}
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

                    {{-- HOSTED BY / WALK-IN --}}
                    <div class="flex items-center gap-x-1">
                        <svg class="size-4 shrink-0" xmlns="http://www.w3.org/2000/svg"
                             viewBox="0 0 24 24" fill="none" stroke="currentColor"
                             stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/>
                            <circle cx="12" cy="7" r="4"/>
                        </svg>
                        <dd>
                            @if($v->user_id === null)
                                Walk-In
                            @else
                                {{ $v->user->user_details->school_id ?? 'Unknown' }}
                            @endif
                        </dd>
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

                {{-- STATUS-SPECIFIC ACTION BUTTONS / FORMS --}}
                <div class="mt-3 space-x-2">
                    @if($v->status === 'pending'
                         && (auth()->user()?->user_details?->role === 'HR Admin'
                             || auth()->user()?->user_details?->role === 'super admin'))

                        {{-- Approve --}}
                        <form action="{{ route('visitors.update', $v->id) }}" method="POST" class="inline">
                            @csrf @method('PATCH')
                            <input type="hidden" name="status" value="approved">
                            <input type="hidden" name="redirect_to" value="{{ route('dashboard') }}">
                            <button type="submit"
                                    class="p-2 rounded border bg-white hover:bg-gray-100 shadow
                             dark:bg-neutral-800 dark:hover:bg-neutral-700">
                                <svg class="size-4 text-black dark:text-gray-200" xmlns="http://www.w3.org/2000/svg"
                                     viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                     stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M20 6 9 17l-5-5"/>
                                </svg>
                            </button>
                        </form>

                        {{-- Deny --}}
                        <form action="{{ route('visitors.update', $v->id) }}" method="POST" class="inline">
                            @csrf @method('PATCH')
                            <input type="hidden" name="status" value="denied">
                            <input type="hidden" name="redirect_to" value="{{ route('dashboard') }}">
                            <button type="submit"
                                    class="p-2 rounded border bg-white hover:bg-gray-100 shadow
                             dark:bg-neutral-800 dark:hover:bg-neutral-700">
                                <svg class="size-4 text-black dark:text-gray-200" xmlns="http://www.w3.org/2000/svg"
                                     viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                     stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M18 6 6 18"/><path d="m6 6 12 12"/>
                                </svg>
                            </button>
                        </form>

                    @elseif($v->status === 'approved')
                        @include('visitors.partials.checkin_form', ['visitor' => $v])

                    @elseif($v->status === 'checked_in')
                        <form action="{{ route('visitors.update', $v->id) }}" method="POST" class="inline">
                            @csrf @method('PATCH')
                            <input type="hidden" name="status" value="checked_out">
                            <input type="hidden" name="redirect_to" value="{{ route('dashboard') }}">
                            <x-primary-button class="bg-gray-700 hover:bg-gray-600 text-white">
                                Check&nbsp;Out
                            </x-primary-button>
                        </form>

                    @elseif($v->status === 'denied')
                        <span class="text-red-400">Visitor denied</span>
                    @endif
                </div>

                {{-- 3-dot ACTION DROPDOWN --}}
                <div class="mt-auto flex justify-end">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="h-8 w-8 grid place-content-center rounded-lg
                     text-neutral-400 hover:bg-neutral-800 dark:hover:bg-neutral-700
                     focus-visible:ring-2 focus-visible:ring-blue-600 transition-colors"
                                    type="button"
                                    aria-label="Visitor actions">
                                <svg class="size-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                                     viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <circle cx="12" cy="12" r="1"/>
                                    <circle cx="19" cy="12" r="1"/>
                                    <circle cx="5" cy="12" r="1"/>
                                </svg>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            {{-- Dropdown header --}}
                            <span class="block px-3 py-2 text-xs font-medium uppercase text-neutral-500 dark:text-neutral-400">
                Actions
            </span>

                            {{-- Dropdown items --}}
                            <div class="border-t border-neutral-200 dark:border-neutral-600"></div>

                            @can('update-visitor', $v)
                                <a href="{{ route('visitors.edit', $v->id) }}"
                                   class="block px-3 py-2 text-sm text-neutral-700 dark:text-neutral-300
                          hover:bg-neutral-100 dark:hover:bg-neutral-700/50 transition-colors">
                                    Edit
                                </a>
                            @endcan

                            <a href="{{ route('visitors.timeline', $v->id) }}"
                               class="block px-3 py-2 text-sm text-neutral-700 dark:text-neutral-300
                      hover:bg-neutral-100 dark:hover:bg-neutral-700/50 transition-colors">
                                View timeline
                            </a>

                            <a href="{{ route('visitors.show', $v->id) }}"
                               class="block px-3 py-2 text-sm text-neutral-700 dark:text-neutral-300
                      hover:bg-neutral-100 dark:hover:bg-neutral-700/50 transition-colors">
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
        {{ $allVisitors->links() }}
    </div>
</div>
