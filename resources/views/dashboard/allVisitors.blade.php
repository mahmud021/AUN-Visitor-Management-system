<h3 class="font-semibold text-lg">
    All Visitors
</h3>


<div class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
    <div class="grid sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-3 sm:gap-6">
        @foreach ($allVisitors as $allVisitor)
            <x-card class="bg-brand-900 text-gray-100 border border-gray-700">
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
                                <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z" />
                            </svg>
                            <span>: {{ $allVisitor->telephone ?? 'Null' }}</span>
                        </p>

                        <!-- School ID -->
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
                            <span>: {{ $allVisitor->user->user_details->school_id ?? 'Null' }}</span>
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
                                        <x-primary-button class="bg-green-600 hover:bg-green-700 text-white">
                                            Approve
                                        </x-primary-button>
                                    </form>

                                    <!-- Deny Form -->
                                    <form action="{{ route('visitors.update', $allVisitor->id) }}" method="POST" class="inline ml-2">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="denied">
                                        <input type="hidden" name="redirect_to" value="{{ route('dashboard') }}">
                                        <x-primary-button class="bg-red-600 hover:bg-red-700 text-white">
                                            Deny
                                        </x-primary-button>
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
                    <div class="hs-dropdown [--placement:bottom-end] relative inline-flex self-start">
                        <button
                            id="hs-table-dropdown-{{ $allVisitor->id }}"
                            type="button"
                            class="hs-dropdown-toggle py-1.5 px-2 inline-flex justify-center items-center gap-2 rounded-lg text-gray-400 hover:text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-600 text-sm"
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
                                <circle cx="12" cy="12" r="1" />
                                <circle cx="19" cy="12" r="1" />
                                <circle cx="5" cy="12" r="1" />
                            </svg>
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
                                <a
                                    class="flex items-center gap-x-3 py-2 px-3 rounded-lg text-sm text-gray-800 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 dark:text-neutral-400 dark:hover:bg-neutral-700 dark:hover:text-neutral-300"
                                    href="{{ route('visitors.timeline', $allVisitor->id) }}"
                                >
                                    Allow Overstay
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </x-card>
        @endforeach

    </div>
    <div class="mt-6 flex justify-center">
        {{ $allVisitors->links() }}
    </div>
</div>
