<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <!-- Title on the left -->
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Inventory Timeline') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="dark:bg-brand-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <!-- Inventory Header -->
                    <div class="mb-8 border-b pb-4">
                        <h1 class="text-2xl font-bold">
                            {{ $inventory->appliance_name ?? 'Null' }}
                        </h1>
                        <p class="text-sm text-gray-600 dark:text-neutral-400">
                            Created on {{ $inventory->created_at->format('l, F j, Y') }}
                        </p>
                    </div>

                    <!-- Timeline -->
                    <div>
                        @forelse($inventory->timelineEvents as $event)
                            <!-- Timeline Item -->
                            <div class="flex gap-x-3">
                                <!-- Left Content: Time of the event -->
                                <div class="w-16 text-end">
                                    <span class="text-xs text-gray-500 dark:text-neutral-400">
                                        {{ \Carbon\Carbon::parse($event->created_at)->format('g:iA') }}
                                    </span>
                                </div>

                                <!-- Icon & Vertical Line -->
                                <div class="relative last:after:hidden after:absolute after:top-7 after:bottom-0 after:start-3.5 after:w-px after:-translate-x-[0.5px] after:bg-gray-200 dark:after:bg-neutral-700">
                                    <div class="relative z-10 size-7 flex justify-center items-center">
                                        <div class="size-2 rounded-full bg-gray-400 dark:bg-neutral-600"></div>
                                    </div>
                                </div>

                                <!-- Right Content: Event details -->
                                <div class="grow pt-0.5 pb-8">
                                    <h3 class="flex gap-x-1.5 font-semibold text-gray-800 dark:text-white">
                                        @if($event->event_type == 'created')
                                            Created Inventory Record
                                        @elseif($event->event_type == 'checked_in')
                                            Checked In Inventory
                                        @elseif($event->event_type == 'checked_out')
                                            Checked Out Inventory
                                        @elseif($event->event_type == 'moved')
                                            Moved Inventory
                                        @else
                                            {{ ucfirst($event->event_type) }}
                                        @endif
                                    </h3>
                                    <p class="mt-1 text-sm text-gray-600 dark:text-neutral-400">
                                        {{ $event->description ?? 'No description' }}
                                    </p>
                                    @if($event->user)
                                        <button
                                            type="button"
                                            class="mt-1 -ms-1 p-1 inline-flex items-center gap-x-2 text-xs
                                                   rounded-lg border border-transparent text-gray-500
                                                   hover:bg-gray-100 focus:outline-none focus:bg-gray-100
                                                   disabled:opacity-50 disabled:pointer-events-none
                                                   dark:text-neutral-400 dark:hover:bg-neutral-700 dark:focus:bg-neutral-700"
                                        >
                                            {{ $event->user->first_name }} {{ $event->user->last_name }}
                                        </button>
                                    @endif
                                </div>
                            </div>
                            <!-- End Timeline Item -->
                        @empty
                            <p class="text-center text-gray-600 dark:text-neutral-400">No timeline events available.</p>
                        @endforelse
                    </div>
                    <!-- End Timeline -->
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
