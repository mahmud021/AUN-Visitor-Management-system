<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Timeline') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <!-- Visitor Header -->
                    <div class="mb-8 border-b pb-4">
                        <h1 class="text-2xl font-bold">
                            {{ $visitor->first_name }} {{ $visitor->last_name }}
                        </h1>
                        <div class="mt-2 grid grid-cols-2 gap-4 text-sm">
                            <div>
                                <span class="text-gray-600 dark:text-neutral-400">Scheduled:</span>
                                <span class="font-medium">
                                    {{ $visitor->expected_arrival->format('M j, Y g:i A') }} -
                                    {{ $visitor->visit_end->format('g:i A') }}
                                </span>
                            </div>
                            @if($visitor->checked_in_at)
                                <div>
                                    <span class="text-gray-600 dark:text-neutral-400">Actual Check-in:</span>
                                    <span class="{{ $visitor->checkin_status_color }} font-medium">
                                    {{ $visitor->checked_in_at->format('M j, Y g:i A') }}
                                    ({{ $visitor->checkin_status }})
                                </span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Timeline -->
                    <div>
                        @forelse($visitor->timelineEvents as $event)
                            <div class="flex gap-x-3">
                                <!-- Time Column -->
                                <div class="w-16 text-end">
                                    <span class="text-xs text-gray-500 dark:text-neutral-400">
                                        {{ $event->occurred_at->format('g:iA') }}
                                    </span>
                                </div>

                                <!-- Timeline Connector -->
                                <div class="relative last:after:hidden after:absolute after:top-7 after:bottom-0 after:start-3.5 after:w-px after:-translate-x-[0.5px] after:bg-gray-200 dark:after:bg-neutral-700">
                                    <div class="relative z-10 size-7 flex justify-center items-center">
                                        @switch($event->event_type)
                                            @case('window_set')
                                                <i class="fa-regular fa-clock text-blue-500"></i>
                                                @break
                                            @case('checked_in')
                                                <div class="size-2 rounded-full bg-green-500"></div>
                                                @break
                                            @case('checked_out')
                                                <div class="size-2 rounded-full bg-red-500"></div>
                                                @break
                                            @default
                                                <div class="size-2 rounded-full bg-gray-400 dark:bg-neutral-600"></div>
                                        @endswitch
                                    </div>
                                </div>

                                <!-- Event Details -->
                                <div class="grow pt-0.5 pb-8">
                                    <h3 class="flex gap-x-1.5 font-semibold text-gray-800 dark:text-white">
                                        @if($event->event_type == 'window_set')
                                            <i class="fa-regular fa-clock mt-1 text-blue-500"></i>
                                            Visit Window Scheduled
                                        @else
                                            {{-- Existing event types --}}
                                        @endif
                                    </h3>

                                    @if($event->event_type == 'window_set')
                                        <div class="mt-2 p-3 bg-blue-50 rounded-lg dark:bg-blue-900/20">
                                            <dl class="grid grid-cols-2 gap-4 text-sm">
                                                <div>
                                                    <dt class="text-gray-600 dark:text-blue-200">Start</dt>
                                                    <dd class="font-medium">
                                                        {{ $visitor->expected_arrival->format('M j, Y g:i A') }}
                                                    </dd>
                                                </div>
                                                <div>
                                                    <dt class="text-gray-600 dark:text-blue-200">End</dt>
                                                    <dd class="font-medium">
                                                        {{ $visitor->visit_end->format('M j, Y g:i A') }}
                                                    </dd>
                                                </div>
                                            </dl>
                                        </div>
                                    @else
                                        {{-- Existing event display --}}
                                    @endif

                                    <!-- User Badge -->
                                    @if($event->user)
                                        <div class="mt-3">
                                        <span class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm dark:bg-neutral-900 dark:border-neutral-700 dark:text-white">
                                            <i class="fa-regular fa-user"></i>
                                            {{ $event->user->full_name }}
                                        </span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <p class="text-center text-gray-600 dark:text-neutral-400">No timeline events available.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
