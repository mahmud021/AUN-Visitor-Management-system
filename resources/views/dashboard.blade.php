<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <!-- Title on the left -->
            <h2 class="font-semibold text-xl leading-tight text-white">
                {{ $user->user_details->role }} Dashboard View
            </h2>

            <!-- Button group on the right -->
            <div class="flex items-center gap-4">
                <!-- Create Visitor button -->
                <x-primary-button
                    type="button"
                    aria-haspopup="dialog"
                    aria-expanded="false"
                    aria-controls="hs-scale-animation-modal"
                    data-hs-overlay="#hs-scale-animation-modal"
                    @class([
                        // Use a dark/gray background for primary actions
                        'bg-gray-700 hover:bg-gray-600 text-white',
                        'cursor-not-allowed opacity-50' => Gate::denies('create-visitor'),
                    ])
                    :disabled="Gate::denies('create-visitor')"
                >
                    Create Visitor
                </x-primary-button>

                <!-- Logout button -->
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit"
                            class="inline-flex items-center px-4 py-2
                                   bg-red-600 hover:bg-red-700
                                   border border-transparent
                                   rounded-md font-medium text-xs text-white uppercase
                                   tracking-widest focus:outline-none
                                   focus:ring-2 focus:ring-red-500 focus:ring-offset-2
                                   transition ease-in-out duration-150">
                        {{ __('Log Out') }}
                    </button>
                </form>

                <!-- Modal Form for Creating a Visitor -->
                <form method="POST" action="{{ route('visitors.store') }}">
                    @csrf
                    <x-modal.wrapper id="hs-scale-animation-modal">
                        <x-modal.header
                            title="Create Visitor"
                            modalId="hs-scale-animation-modal"
                        />
                        <div class="p-4 overflow-y-auto bg-brand-900 text-gray-100">
                            <div class="grid grid-cols-1 gap-4 lg:gap-4">
                                <div class="space-y-2">
                                    <x-form.input
                                        name="first_name"
                                        label="First Name"
                                        type="text"
                                        value="{{ old('first_name') }}"
                                        class="bg-gray-800 border-gray-700 text-gray-200"
                                    />
                                    <x-input-error :messages="$errors->get('first_name')" class="mt-1"/>
                                </div>
                                <div class="space-y-2">
                                    <x-form.input
                                        name="last_name"
                                        label="Last Name"
                                        type="text"
                                        value="{{ old('last_name') }}"
                                        class="bg-gray-800 border-gray-700 text-gray-200"
                                    />
                                    <x-input-error :messages="$errors->get('last_name')" class="mt-1"/>
                                </div>
                                <div class="space-y-2">
                                    <x-form.input
                                        name="telephone"
                                        label="Telephone Number"
                                        type="text"
                                        value="{{ old('telephone') }}"
                                        class="bg-gray-800 border-gray-700 text-gray-200"
                                    />
                                    <x-input-error :messages="$errors->get('telephone')" class="mt-1"/>
                                </div>
                                <div class="space-y-2">
                                    <x-form.input
                                        name="expected_arrival"
                                        label="Expected Arrival (Date & Time)"
                                        type="datetime-local"
                                        value="{{ old('expected_arrival') }}"
                                        class="bg-gray-800 border-gray-700 text-gray-200"
                                    />
                                    <x-input-error :messages="$errors->get('expected_arrival')" class="mt-1"/>
                                </div>
                            </div>
                        </div>
                        <x-modal.footer class="bg-gray-900">
                            <x-primary-button
                                type="submit"
                                class="bg-gray-700 hover:bg-gray-600 text-white"
                            >
                                Submit
                            </x-primary-button>
                        </x-modal.footer>
                    </x-modal.wrapper>
                </form>
            </div>
        </div>
    </x-slot>

    <!-- Main dashboard content -->
    <!-- Use a dark background for the entire page -->
    <div class="py-12 bg-primary text-white min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden shadow-sm sm:rounded-lg">
                <nav class="flex justify-center gap-x-1" aria-label="Tabs" role="tablist" aria-orientation="horizontal">
                    <!-- MY VISITORS -->
                    <button type="button"
                            class="hs-tab-active:bg-gray-200 hs-tab-active:text-gray-800 hs-tab-active:hover:text-gray-800 dark:hs-tab-active:bg-neutral-700 dark:hs-tab-active:text-white py-3 px-4 inline-flex items-center gap-x-2 bg-transparent text-sm font-medium text-center text-gray-500 rounded-lg hover:text-blue-600 focus:outline-hidden focus:text-blue-600 disabled:opacity-50 disabled:pointer-events-none dark:text-neutral-500 dark:hover:text-neutral-400 dark:focus:text-neutral-400 active"
                            id="pills-on-gray-color-item-1"
                            aria-selected="true"
                            data-hs-tab="#pills-on-gray-color-1"
                            aria-controls="pills-on-gray-color-1"
                            role="tab">
                        MY VISITORS
                    </button>
                    <!-- APPROVED VISITORS TODAY -->
                    <button type="button"
                            class="hs-tab-active:bg-gray-200 hs-tab-active:text-gray-800 hs-tab-active:hover:text-gray-800 dark:hs-tab-active:bg-neutral-700 dark:hs-tab-active:text-white py-3 px-4 inline-flex items-center gap-x-2 bg-transparent text-sm font-medium text-center text-gray-500 rounded-lg hover:text-blue-600 focus:outline-hidden focus:text-blue-600 disabled:opacity-50 disabled:pointer-events-none dark:text-neutral-500 dark:hover:text-neutral-400 dark:focus:text-neutral-400"
                            id="pills-on-gray-color-item-2"
                            aria-selected="false"
                            data-hs-tab="#pills-on-gray-color-2"
                            aria-controls="pills-on-gray-color-2"
                            role="tab">
                        APPROVED VISITORS TODAY
                    </button>
                    <!-- CHECKED-IN VISITORS -->
                    <button type="button"
                            class="hs-tab-active:bg-gray-200 hs-tab-active:text-gray-800 hs-tab-active:hover:text-gray-800 dark:hs-tab-active:bg-neutral-700 dark:hs-tab-active:text-white py-3 px-4 inline-flex items-center gap-x-2 bg-transparent text-sm font-medium text-center text-gray-500 rounded-lg hover:text-blue-600 focus:outline-hidden focus:text-blue-600 disabled:opacity-50 disabled:pointer-events-none dark:text-neutral-500 dark:hover:text-neutral-400 dark:focus:text-neutral-400"
                            id="pills-on-gray-color-item-3"
                            aria-selected="false"
                            data-hs-tab="#pills-on-gray-color-3"
                            aria-controls="pills-on-gray-color-3"
                            role="tab">
                        CHECKED‑IN VISITORS
                    </button>
                    <!-- ALL VISITORS -->
                    <button type="button"
                            class="hs-tab-active:bg-gray-200 hs-tab-active:text-gray-800 hs-tab-active:hover:text-gray-800 dark:hs-tab-active:bg-neutral-700 dark:hs-tab-active:text-white py-3 px-4 inline-flex items-center gap-x-2 bg-transparent text-sm font-medium text-center text-gray-500 rounded-lg hover:text-blue-600 focus:outline-hidden focus:text-blue-600 disabled:opacity-50 disabled:pointer-events-none dark:text-neutral-500 dark:hover:text-neutral-400 dark:focus:text-neutral-400"
                            id="pills-on-gray-color-item-4"
                            aria-selected="false"
                            data-hs-tab="#pills-on-gray-color-4"
                            aria-controls="pills-on-gray-color-4"
                            role="tab">
                        ALL VISITORS
                    </button>
                    <!-- CHECKED‑OUT VISITORS -->
                    <button type="button"
                            class="hs-tab-active:bg-gray-200 hs-tab-active:text-gray-800 hs-tab-active:hover:text-gray-800 dark:hs-tab-active:bg-neutral-700 dark:hs-tab-active:text-white py-3 px-4 inline-flex items-center gap-x-2 bg-transparent text-sm font-medium text-center text-gray-500 rounded-lg hover:text-blue-600 focus:outline-hidden focus:text-blue-600 disabled:opacity-50 disabled:pointer-events-none dark:text-neutral-500 dark:hover:text-neutral-400 dark:focus:text-neutral-400"
                            id="pills-on-gray-color-item-5"
                            aria-selected="false"
                            data-hs-tab="#pills-on-gray-color-5"
                            aria-controls="pills-on-gray-color-5"
                            role="tab">
                        CHECKED‑OUT VISITORS
                    </button>
                </nav>

                <div class="mt-3 text-center">
                    <!-- MY VISITORS Tab Panel -->
                    <div id="pills-on-gray-color-1" role="tabpanel" aria-labelledby="pills-on-gray-color-item-1">
                        <div class="grid sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-3 sm:gap-6">
                            @foreach ($myVisitors as $visitor)
                                <x-card class="text-gray-100 border border-gray-700 my-2">
                                    <div class="flex justify-between items-center gap-x-3">
                                        <div class="grow">
                                            <h3 class="font-semibold text-lg mt-2">
                                                {{ $visitor->first_name ?? 'Null' }} {{ $visitor->last_name ?? 'Null' }}
                                            </h3>
                                            <p class="text-sm text-gray-400 mt-2">
                                                Telephone: {{ $visitor->telephone ?? 'Null' }}
                                            </p>
                                            <p class="mt-2 text-base font-semibold text-blue-400">
                                                Access Code:
                                                <span class="inline-block bg-gray-800 text-gray-100 rounded px-2 py-1 ml-1">
                                    {{ $visitor->visitor_code ?? 'Null' }}
                                </span>
                                            </p>
                                            <p class="text-sm text-gray-400 mt-2">
                                                {{ \Carbon\Carbon::parse($visitor->expected_arrival)->format('M d, h:i A') }}
                                            </p>
                                            <p class="mt-2">
                                                <x-status-badge status="{{ $visitor->status ?? 'Null' }}" />
                                            </p>
                                        </div>
                                        <a href="{{ route('visitors.timeline', $visitor->id) }}">
                                            <svg class="shrink-0 size-5 text-gray-300" xmlns="http://www.w3.org/2000/svg"
                                                 width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                 stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                 stroke-linejoin="round">
                                                <path d="m9 18 6-6-6-6"/>
                                            </svg>
                                        </a>
                                    </div>
                                </x-card>
                            @endforeach
                        </div>
                    </div>

                    <!-- APPROVED VISITORS TODAY Tab Panel -->
                    <div id="pills-on-gray-color-2" role="tabpanel" aria-labelledby="pills-on-gray-color-item-2" class="hidden">
                        <div class="grid sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-3 sm:gap-6">
                            @foreach ($approvedVisitorsList as $visitor)
                                <x-card class="text-gray-100 border border-gray-700 my-2">
                                    <div class="flex justify-between items-center gap-x-3">
                                        <div class="grow">
                                            <h3 class="font-semibold text-lg mt-2">
                                                {{ $visitor->first_name ?? 'Null' }} {{ $visitor->last_name ?? 'Null' }}
                                            </h3>
                                            <p class="text-sm text-gray-400 mt-2">
                                                Telephone: {{ $visitor->telephone ?? 'Null' }}
                                            </p>
                                            <p class="mt-2 text-base font-semibold text-blue-400">
                                                Access Code:
                                                <span class="inline-block bg-gray-800 text-gray-100 rounded px-2 py-1 ml-1">
                                    {{ $visitor->visitor_code ?? 'Null' }}
                                </span>
                                            </p>
                                            <p class="text-sm text-gray-400 mt-2">
                                                {{ \Carbon\Carbon::parse($visitor->expected_arrival)->format('M d, h:i A') }}
                                            </p>
                                            <p class="mt-2">
                                                <x-status-badge status="{{ $visitor->status ?? 'Null' }}" />
                                            </p>
                                        </div>
                                        <a href="{{ route('visitors.timeline', $visitor->id) }}">
                                            <svg class="shrink-0 size-5 text-gray-300" xmlns="http://www.w3.org/2000/svg"
                                                 width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                 stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                 stroke-linejoin="round">
                                                <path d="m9 18 6-6-6-6"/>
                                            </svg>
                                        </a>
                                    </div>
                                </x-card>
                            @endforeach
                        </div>
                    </div>

                    <!-- CHECKED‑IN VISITORS Tab Panel -->
                    <div id="pills-on-gray-color-3" role="tabpanel" aria-labelledby="pills-on-gray-color-item-3" class="hidden">
                        <div class="grid sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-3 sm:gap-6">
                            @foreach ($checkedInVisitors as $visitor)
                                <x-card class="text-gray-100 border border-gray-700 my-2">
                                    <div class="flex justify-between items-center gap-x-3">
                                        <div class="grow">
                                            <h3 class="font-semibold text-lg mt-2">
                                                {{ $visitor->first_name ?? 'Null' }} {{ $visitor->last_name ?? 'Null' }}
                                            </h3>
                                            <p class="text-sm text-gray-400 mt-2">
                                                Telephone: {{ $visitor->telephone ?? 'Null' }}
                                            </p>
                                            <p class="mt-2 text-base font-semibold text-blue-400">
                                                Access Code:
                                                <span class="inline-block bg-gray-800 text-gray-100 rounded px-2 py-1 ml-1">
                                    {{ $visitor->visitor_code ?? 'Null' }}
                                </span>
                                            </p>
                                            <p class="text-sm text-gray-400 mt-2">
                                                {{ \Carbon\Carbon::parse($visitor->expected_arrival)->format('M d, h:i A') }}
                                            </p>
                                            <p class="mt-2">
                                                <x-status-badge status="{{ $visitor->status ?? 'Null' }}" />
                                            </p>
                                        </div>
                                        <a href="{{ route('visitors.timeline', $visitor->id) }}">
                                            <svg class="shrink-0 size-5 text-gray-300" xmlns="http://www.w3.org/2000/svg"
                                                 width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                 stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                 stroke-linejoin="round">
                                                <path d="m9 18 6-6-6-6"/>
                                            </svg>
                                        </a>
                                    </div>
                                </x-card>
                            @endforeach
                        </div>
                    </div>

                    <!-- ALL VISITORS Tab Panel -->
                    <div id="pills-on-gray-color-4" role="tabpanel" aria-labelledby="pills-on-gray-color-item-4" class="hidden">
                        <div class="grid sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-3 sm:gap-6">
                            @foreach ($allVisitors as $visitor)
                                <x-card class="text-gray-100 border border-gray-700 my-2">
                                    <div class="flex justify-between items-center gap-x-3">
                                        <div class="grow">
                                            <h3 class="font-semibold text-lg mt-2">
                                                {{ $visitor->first_name ?? 'Null' }} {{ $visitor->last_name ?? 'Null' }}
                                            </h3>
                                            <p class="text-sm text-gray-400 mt-2">
                                                Telephone: {{ $visitor->telephone ?? 'Null' }}
                                            </p>
                                            <p class="mt-2 text-base font-semibold text-blue-400">
                                                Access Code:
                                                <span class="inline-block bg-gray-800 text-gray-100 rounded px-2 py-1 ml-1">
                                    {{ $visitor->visitor_code ?? 'Null' }}
                                </span>
                                            </p>
                                            <p class="text-sm text-gray-400 mt-2">
                                                {{ \Carbon\Carbon::parse($visitor->expected_arrival)->format('M d, h:i A') }}
                                            </p>
                                            <p class="mt-2">
                                                <x-status-badge status="{{ $visitor->status ?? 'Null' }}" />
                                            </p>
                                        </div>
                                        <a href="{{ route('visitors.timeline', $visitor->id) }}">
                                            <svg class="shrink-0 size-5 text-gray-300" xmlns="http://www.w3.org/2000/svg"
                                                 width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                 stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                 stroke-linejoin="round">
                                                <path d="m9 18 6-6-6-6"/>
                                            </svg>
                                        </a>
                                    </div>
                                </x-card>
                            @endforeach
                        </div>
                    </div>

                    <!-- CHECKED‑OUT VISITORS Tab Panel -->
                    <div id="pills-on-gray-color-5" role="tabpanel" aria-labelledby="pills-on-gray-color-item-5" class="hidden">
                        <div class="grid sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-3 sm:gap-6">
                            @foreach ($checkedOutVisitors as $visitor)
                                <x-card class="text-gray-100 border border-gray-700 my-2">
                                    <div class="flex justify-between items-center gap-x-3">
                                        <div class="grow">
                                            <h3 class="font-semibold text-lg mt-2">
                                                {{ $visitor->first_name ?? 'Null' }} {{ $visitor->last_name ?? 'Null' }}
                                            </h3>
                                            <p class="text-sm text-gray-400 mt-2">
                                                Telephone: {{ $visitor->telephone ?? 'Null' }}
                                            </p>
                                            <p class="mt-2 text-base font-semibold text-blue-400">
                                                Access Code:
                                                <span class="inline-block bg-gray-800 text-gray-100 rounded px-2 py-1 ml-1">
                                    {{ $visitor->visitor_code ?? 'Null' }}
                                </span>
                                            </p>
                                            <p class="text-sm text-gray-400 mt-2">
                                                {{ \Carbon\Carbon::parse($visitor->expected_arrival)->format('M d, h:i A') }}
                                            </p>
                                            <p class="mt-2">
                                                <x-status-badge status="{{ $visitor->status ?? 'Null' }}" />
                                            </p>
                                        </div>
                                        <a href="{{ route('visitors.timeline', $visitor->id) }}">
                                            <svg class="shrink-0 size-5 text-gray-300" xmlns="http://www.w3.org/2000/svg"
                                                 width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                 stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                 stroke-linejoin="round">
                                                <path d="m9 18 6-6-6-6"/>
                                            </svg>
                                        </a>
                                    </div>
                                </x-card>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- All Visitors Section -->
                @can('view-all-visitors')
                    <h3 class="font-semibold text-lg">
                        All Visitors
                    </h3>


                    <div class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
                        <div class="grid sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-3 sm:gap-6">
                            @foreach ($allVisitors as $allVisitor)
                                <x-card class="bg-brand-900 text-gray-100 border border-gray-700">
                                    <div class="flex justify-between items-center gap-x-3">
                                        <div class="grow">
                                            <h3 class="font-semibold text-lg">
                                                {{ $allVisitor->first_name ?? 'Null' }} {{ $allVisitor->last_name ?? 'Null' }}
                                            </h3>
                                            <p class="text-sm text-gray-400 mt-2">
                                                Telephone: {{ $allVisitor->telephone ?? 'Null' }}
                                            </p>
                                            <p class="text-sm text-gray-400 mt-2">
                                                Hosted By: {{ $allVisitor->user->user_details->school_id ?? 'Null' }}
                                            </p>
                                            <p class="text-sm text-gray-400 mt-2">
                                                {{ \Carbon\Carbon::parse($allVisitor->expected_arrival)->format('M d, h:i A') }}
                                            </p>
                                            <p class="mt-2">
                                                <x-status-badge status="{{ $allVisitor->status }}" />
                                            </p>

                                            <!-- Status actions -->
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
                                                    <!-- Check-in Form -->
                                                    <form action="{{ route('visitors.update', $allVisitor->id) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="status" value="checked_in">
                                                        <input type="hidden" name="redirect_to" value="{{ route('dashboard') }}">

                                                        <div class="flex items-center gap-2 mb-4">
                                                            <x-primary-button class="bg-gray-700 hover:bg-gray-600 text-white">
                                                                Check In
                                                            </x-primary-button>
                                                        </div>
                                                        <div>
                                                            <label for="visitor_code" class="block text-sm font-medium mb-2">
                                                                Enter Visitor Code
                                                            </label>
                                                            <div class="py-2 px-3 bg-brand-900 border border-brand-700 rounded-lg">
                                                                <div class="flex gap-x-3" data-hs-pin-input>
                                                                    <input
                                                                        id="visitor_code_1"
                                                                        class="w-8 h-8 text-sm text-center p-0 border-brand-700 rounded-md focus:border-brand-500 focus:ring-brand-500 bg-brand-900 text-brand-200"
                                                                        type="text"
                                                                        placeholder="○"
                                                                        data-hs-pin-input-item
                                                                        autofocus
                                                                        name="visitor_code[]"
                                                                    >
                                                                    <input
                                                                        id="visitor_code_2"
                                                                        class="w-8 h-8 text-sm text-center p-0 border-brand-700 rounded-md focus:border-brand-500 focus:ring-brand-500 bg-brand-900 text-brand-200"
                                                                        type="text"
                                                                        placeholder="○"
                                                                        data-hs-pin-input-item
                                                                        name="visitor_code[]"
                                                                    >
                                                                    <input
                                                                        id="visitor_code_3"
                                                                        class="w-8 h-8 text-sm text-center p-0 border-brand-700 rounded-md focus:border-brand-500 focus:ring-brand-500 bg-brand-900 text-brand-200"
                                                                        type="text"
                                                                        placeholder="○"
                                                                        data-hs-pin-input-item
                                                                        name="visitor_code[]"
                                                                    >
                                                                    <input
                                                                        id="visitor_code_4"
                                                                        class="w-8 h-8 text-sm text-center p-0 border-brand-700 rounded-md focus:border-brand-500 focus:ring-brand-500 bg-brand-900 text-brand-200"
                                                                        type="text"
                                                                        placeholder="○"
                                                                        data-hs-pin-input-item
                                                                        name="visitor_code[]"
                                                                    >
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
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
                                        <a href="{{ route('visitors.timeline', $allVisitor->id) }}">
                                            <svg class="shrink-0 size-5 text-gray-300" xmlns="http://www.w3.org/2000/svg"
                                                 width="24" height="24" viewBox="0 0 24 24"
                                                 fill="none" stroke="currentColor" stroke-width="2"
                                                 stroke-linecap="round" stroke-linejoin="round">
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

                <!-- My Visitors Section -->
                <h3 class="font-semibold text-lg">
                    My Visitors
                </h3>
                <div class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">

                    <div class="grid sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-3 sm:gap-6">
                        @foreach ($myVisitors as $myVisitor)
                            <x-card class="text-gray-100 border border-gray-700">
                                <div class="flex justify-between items-center gap-x-3">
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
                                            {{ \Carbon\Carbon::parse($myVisitor->expected_arrival)->format('M d, h:i A') }}
                                        </p>
                                        <p class="mt-2">
                                            <x-status-badge status="{{ $myVisitor->status ?? 'Null' }}" />
                                        </p>
                                    </div>
                                    <a href="{{ route('visitors.timeline', $myVisitor->id) }}">
                                        <svg class="shrink-0 size-5 text-gray-300" xmlns="http://www.w3.org/2000/svg"
                                             width="24" height="24" viewBox="0 0 24 24"
                                             fill="none" stroke="currentColor" stroke-width="2"
                                             stroke-linecap="round" stroke-linejoin="round">
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


</x-app-layout>
