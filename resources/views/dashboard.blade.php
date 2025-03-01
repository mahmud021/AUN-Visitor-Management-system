<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <!-- Title on the left -->
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ $user->user_details->role }} Dashboard View
            </h2>
            <button id="hs-new-toast" type="button" class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
                Call toast
            </button>

            <!-- Button group on the right -->
            <div class="flex items-center gap-4">
                <!-- Create Visitor button -->
                <x-primary-button
                    type="button"
                    aria-haspopup="dialog"
                    aria-expanded="false"
                    aria-controls="hs-scale-animation-modal"
                    data-hs-overlay="#hs-scale-animation-modal"
                    :disabled="Gate::denies('create-visitor')"
                >
                    Create Visitor
                </x-primary-button>

                <!-- Logout button -->
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-red-50 border border-transparent rounded-md font-medium text-xs text-red-600 uppercase tracking-widest hover:bg-red-100 focus:bg-red-100 active:bg-red-200 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150 dark:hover:bg-red-500/10">
                        {{ __('Log Out') }}
                    </button>
                </form>

                <!-- Modal Form -->
                <form method="POST" action="{{ route('visitors.store') }}">
                    @csrf
                    <x-modal.wrapper id="hs-scale-animation-modal">
                        <x-modal.header
                            title="Create Visitor"
                            modalId="hs-scale-animation-modal"
                        />
                        <div class="p-4 overflow-y-auto">
                            <div class="grid grid-cols-1 gap-4 lg:gap-4">
                                <div class="space-y-2">
                                    <x-form.input name="first_name" label="First Name" type="text" value="{{ old('first_name') }}"/>
                                    <x-input-error :messages="$errors->get('first_name')" class="mt-1"/>
                                </div>
                                <div class="space-y-2">
                                    <x-form.input name="last_name" label="Last Name" type="text" value="{{ old('last_name') }}"/>
                                    <x-input-error :messages="$errors->get('last_name')" class="mt-1"/>
                                </div>
                                <div class="space-y-2">
                                    <x-form.input name="telephone" label="Telephone Number" type="text" value="{{ old('telephone') }}"/>
                                    <x-input-error :messages="$errors->get('telephone')" class="mt-1"/>
                                </div>
                                <div class="space-y-2">
                                    <x-form.input
                                        name="expected_arrival"
                                        label="Expected Arrival (Date & Time)"
                                        type="datetime-local"
                                        value="{{ old('expected_arrival') }}"
                                    />
                                    <x-input-error :messages="$errors->get('expected_arrival')" class="mt-1"/>
                                </div>
                            </div>
                        </div>
                        <x-modal.footer>
                            <x-primary-button type="submit">
                                Submit
                            </x-primary-button>
                        </x-modal.footer>
                    </x-modal.wrapper>
                </form>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-white dark:bg-gray-900">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden shadow-sm sm:rounded-lg">
                <!-- All Visitors Section (Visible only to Security and Super Admin) -->
                @can('view-all-visitors')
                    <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
                        <x-stat-card title="Expected Visitors Today" :value="$expectedVisitors" />
                        <x-stat-card title="Checked-In Visitors" :value="$checkedInCount" />
                        <x-stat-card title="Currently On-Campus Visitors" :value="$onCampusCount" />
                        <x-stat-card title="Checked-Out Visitors" :value="$checkedOutCount" />
                    </div>

                    <div class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
                        <div class="grid sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-3 sm:gap-6">
                            @foreach ($allVisitors as $allVisitor)
                                <x-card>
                                    <div class="flex justify-between items-center gap-x-3">
                                        <div class="grow">
                                            <h3 class="group-hover:text-blue-600 font-semibold text-gray-800 dark:group-hover:text-neutral-200 dark:text-neutral-200">
                                                {{ $allVisitor->first_name ?? 'Null' }} {{ $allVisitor->last_name ?? 'Null' }}
                                            </h3>
                                            <p class="text-sm text-gray-500 dark:text-neutral-500 mt-2">
                                                Telephone: {{ $allVisitor->telephone ?? 'Null' }}
                                            </p>
                                            <p class="text-sm text-gray-500 dark:text-neutral-500 mt-2">
                                                {{ \Carbon\Carbon::parse($allVisitor->expected_arrival)->format('M d, h:i A') }}
                                            </p>
                                            <!-- Status actions -->
                                            <div class="mt-3">
                                                @if($allVisitor->status == 'pending')
                                                    @if(auth()->user()?->user_details?->role === 'HR Admin' || auth()->user()?->user_details?->role === 'super admin')
                                                        <form action="{{ route('visitors.update', $allVisitor->id) }}" method="POST" class="inline">
                                                            @csrf
                                                            @method('PATCH')
                                                            <input type="hidden" name="status" value="approved">
                                                            <input type="hidden" name="redirect_to" value="{{ route('dashboard') }}">
                                                            <x-primary-button>
                                                                Approve
                                                            </x-primary-button>
                                                        </form>
                                                    @endif
                                                @elseif($allVisitor->status == 'approved')
                                                    <form action="{{ route('visitors.update', $allVisitor->id) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="status" value="checked_in">
                                                        <input type="hidden" name="redirect_to" value="{{ route('dashboard') }}">
                                                        <div class="flex items-center gap-2">
                                                            <x-primary-button>
                                                                Check In
                                                            </x-primary-button>
                                                        </div>
                                                        <div class="relative">
                                                            <x-floating-input name="visitor_code" label="Visitor Code" />
                                                        </div>
                                                    </form>
                                                @elseif($allVisitor->status == 'checked_in')
                                                    <form action="{{ route('visitors.update', $allVisitor->id) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="status" value="checked_out">
                                                        <input type="hidden" name="redirect_to" value="{{ route('dashboard') }}">
                                                        <x-primary-button>
                                                            Check Out
                                                        </x-primary-button>
                                                    </form>
                                                @endif
                                            </div>
                                            <p class="mt-2">
                                                <x-status-badge status="{{ $allVisitor->status }}" />
                                            </p>
                                        </div>
                                        <a href="{{ route('visitors.timeline', $allVisitor->id) }}">
                                            <svg class="shrink-0 size-5 text-gray-800 dark:text-neutral-200" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="m9 18 6-6-6-6"/>
                                            </svg>
                                        </a>
                                    </div>
                                </x-card>
                            @endforeach
                        </div>
                        <div class="mt-6 flex justify-center">
                            {{ $allVisitors->links() }}
                        </div>
                    </div>
                @endcan

                <!-- My Visitors Section (Visible to all authenticated users) -->
                <div class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
                    <div class="grid sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-3 sm:gap-6">
                        @foreach ($myVisitors as $myVisitor)
                            <x-card>
                                <div class="flex justify-between items-center gap-x-3">
                                    <div class="grow">
                                        <h3 class="group-hover:text-blue-600 font-semibold text-gray-800 mt-2 dark:group-hover:text-neutral-200 dark:text-neutral-200">
                                            {{ $myVisitor->first_name ?? 'Null' }} {{ $myVisitor->last_name ?? 'Null' }}
                                        </h3>
                                        <p class="text-sm text-gray-500 dark:text-neutral-500 mt-2">
                                            Telephone: {{ $myVisitor->telephone ?? 'Null' }}
                                        </p>
                                        <p class="mt-2 text-lg font-bold text-blue-600">
                                            Access Code:
                                            <span class="inline-block bg-gray-200 text-gray-800 rounded px-2 py-1">
                                                {{ $myVisitor->visitor_code ?? 'Null' }}
                                            </span>
                                        </p>
                                        <p class="text-sm text-gray-500 dark:text-neutral-500 mt-2">
                                            {{ \Carbon\Carbon::parse($myVisitor->expected_arrival)->format('M d, h:i A') }}
                                        </p>
                                        <p class="mt-2">
                                            <x-status-badge status="{{ $myVisitor->status ?? 'Null' }}" />
                                        </p>
                                    </div>
                                    <a href="{{ route('visitors.timeline', $myVisitor->id) }}">
                                        <svg class="shrink-0 size-5 text-gray-800 dark:text-neutral-200" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="m9 18 6-6-6-6"/>
                                        </svg>
                                    </a>
                                </div>
                            </x-card>
                        @endforeach
                    </div>
                    <div class="mt-6 flex justify-center">
                        {{ $myVisitors->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            function tostifyCustomClose(el) {
                const parent = el.closest('.toastify');
                const close = parent.querySelector('.toast-close');
                close.click();
            }

            window.addEventListener('load', () => {
                (function () {
                    let i = 0;
                    const callToast = document.querySelector("#hs-new-toast");
                    const toastMarkup1 = `
                    <div class="max-w-xs relative bg-white border border-gray-200 rounded-xl shadow-lg dark:bg-neutral-800 dark:border-neutral-700" role="alert" tabindex="-1" aria-labelledby="hs-toast-avatar-label">
                        <div class="flex p-4">
                            <div class="shrink-0">
                                <img class="inline-block size-8 rounded-full" src="https://images.unsplash.com/photo-1568602471122-7832951cc4c5?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=facearea&facepad=2&w=300&h=300&q=80" alt="Avatar">
                                <button onclick="tostifyCustomClose(this)" type="button" class="absolute top-3 end-3 inline-flex shrink-0 justify-center items-center size-5 rounded-lg text-gray-800 opacity-50 hover:opacity-100 focus:outline-none focus:opacity-100 dark:text-white" aria-label="Close">
                                    <span class="sr-only">Close</span>
                                    <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"></path><path d="m6 6 12 12"></path></svg>
                                </button>
                            </div>
                            <div class="ms-4 me-5">
                                <h3 id="hs-toast-avatar-label" class="text-gray-800 font-medium text-sm dark:text-white">
                                    <span class="font-semibold">James</span> mentioned you in a comment
                                </h3>
                                <div class="mt-1 text-sm text-gray-600 dark:text-neutral-400">
                                    Nice work! Keep it up!
                                </div>
                                <div class="mt-3">
                                    <button type="button" class="text-blue-600 decoration-2 hover:underline font-medium text-sm focus:outline-none focus:underline dark:text-blue-500">
                                        Mark as read
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                    const toastMarkup2 = `
                    <div class="flex p-4">
                        <p class="text-sm text-gray-700 dark:text-neutral-400">Your email has been sent</p>
                        <div class="ms-auto">
                            <button onclick="tostifyCustomClose(this)" type="button" class="inline-flex shrink-0 justify-center items-center size-5 rounded-lg text-gray-800 opacity-50 hover:opacity-100 focus:outline-none focus:opacity-100 dark:text-white" aria-label="Close">
                                <span class="sr-only">Close</span>
                                <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"></path><path d="m6 6 12 12"></path></svg>
                            </button>
                        </div>
                    </div>
                `;

                    callToast.addEventListener("click", () => {
                        Toastify({
                            text: i % 3 ? toastMarkup1 : toastMarkup2,
                            className: "hs-toastify-on:opacity-100 opacity-0 fixed -top-[150px] right-[20px] z-[90] transition-all duration-300 w-[320px] bg-white text-sm text-gray-700 border border-gray-200 rounded-xl shadow-lg [&>.toast-close]:hidden dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-400",
                            duration: 3000,
                            close: true,
                            escapeMarkup: false
                        }).showToast();

                        i++;
                    });
                })();
            });
        </script>
    @endpush
</x-app-layout>
