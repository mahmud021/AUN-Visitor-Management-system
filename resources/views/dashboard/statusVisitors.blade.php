<div class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
    <div class="grid gap-6 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4">
        @forelse ($visitors as $v)
        <x-card class="pt-6"> {{-- add padding-top to the whole card --}}
            <div class="absolute top-4 right-4">
                <x-status-badge :status="$v->status" />
            </div>

            <h3 class="text-lg font-bold tracking-tight mt-6">
                {{ $v->first_name }} {{ $v->last_name }}
            </h3>

            {{-- META block … --}}
            <dl class="space-y-1.5 text-sm text-neutral-400">
                {{-- PHONE --}}
                <div class="grid grid-cols-[auto_1fr] items-center gap-x-2">
                    <svg class="size-4 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path d="M22 16.92v3a2 2 0 0 1-2.18 2
                       19.79 19.79 0 0 1-8.63-3.07
                       19.5 19.5 0 0 1-6-6
                       19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2
                       2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81
                       2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27
                       a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7
                       A2 2 0 0 1 22 16.92z"/>
                    </svg>
                    <dd>{{ $v->telephone ?? '—' }}</dd>
                </div>

                {{-- HOST / WALK-IN --}}
                <div class="grid grid-cols-[auto_1fr] items-center gap-x-2">
                    <svg class="size-4 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
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
                <div class="grid grid-cols-[auto_1fr] items-center gap-x-2">
                    <svg class="size-4 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path d="M8 2v4M16 2v4M3 10h18"/>
                        <rect x="3" y="4" width="18" height="18" rx="2"/>
                    </svg>
                    <dd>{{ \Carbon\Carbon::parse($v->visit_date)->format('M d') }}</dd>
                </div>

                {{-- TIME RANGE --}}
                <div class="grid grid-cols-[auto_1fr] items-center gap-x-2">
                    <svg class="size-4 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"/>
                        <polyline points="12 6 12 12 16 14"/>
                    </svg>
                    <dd>
                        {{ \Carbon\Carbon::parse($v->start_time)->format('h:i A') }} –
                        {{ \Carbon\Carbon::parse($v->end_time)->format('h:i A') }}
                    </dd>
                </div>
            </dl>

            <div class="mt-auto flex items-center gap-2">
                @if($v->status == 'pending')
                    @if(auth()->user()?->user_details?->role === 'HR Admin' || auth()->user()?->user_details?->role === 'super admin')
                        <!-- Approve Form -->
                        <form action="{{ route('visitors.update', $v->id) }}" method="POST" class="inline">
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
                        <form action="{{ route('visitors.update', $v->id) }}" method="POST" class="inline ml-2">
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
                @elseif($v->status == 'approved')
                    @include('visitors.partials.checkin_form', ['visitor' => $v])
                @elseif($v->status == 'checked_in')
                    <!-- Check-out Form -->
                    <form action="{{ route('visitors.update', $v->id) }}" method="POST" class="inline">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="checked_out">
                        <input type="hidden" name="redirect_to" value="{{ route('dashboard') }}">
                        <x-primary-button class="bg-gray-700 hover:bg-gray-600 text-white">
                            Check Out
                        </x-primary-button>
                    </form>
                @elseif($v->status == 'denied')
                    <span class="text-red-400">Visitor denied</span>
                @endif
            </div>
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
    @empty
        <div class="col-span-full text-center text-gray-400 py-8">
            No visitors in this list.
        </div>
    @endforelse
</div>
</div>

{{-- PAGINATION --}}
@if ($visitors instanceof \Illuminate\Contracts\Pagination\Paginator)
    <div class="mt-8 flex justify-center">
        {{ $visitors->links() }}
    </div>
@endif
