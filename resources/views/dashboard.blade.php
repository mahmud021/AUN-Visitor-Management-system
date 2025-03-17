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
                        <x-modal.header title="Create Visitor" modalId="hs-scale-animation-modal" />
                        <div class="p-4 overflow-y-auto bg-brand-900 text-gray-100">
                            <div class="grid grid-cols-1 gap-4 lg:gap-4">
                                <div class="space-y-2">
                                    <x-form.input name="first_name" label="First Name" type="text" value="{{ old('first_name') }}" class="bg-gray-800 border-gray-700 text-gray-200" />
                                    <x-input-error :messages="$errors->get('first_name')" class="mt-1"/>
                                </div>
                                <div class="space-y-2">
                                    <x-form.input name="last_name" label="Last Name" type="text" value="{{ old('last_name') }}" class="bg-gray-800 border-gray-700 text-gray-200" />
                                    <x-input-error :messages="$errors->get('last_name')" class="mt-1"/>
                                </div>
                                <div class="space-y-2">
                                    <x-form.input name="telephone" label="Telephone Number" type="text" value="{{ old('telephone') }}" class="bg-gray-800 border-gray-700 text-gray-200" />
                                    <x-input-error :messages="$errors->get('telephone')" class="mt-1"/>
                                </div>
                                <div class="space-y-2">
                                    <x-form.input name="visit_date" label="Visit Date" type="date" value="{{ old('visit_date') }}" class="bg-gray-800 border-gray-700 text-gray-200" />
                                    <x-input-error :messages="$errors->get('visit_date')" class="mt-1"/>
                                </div>
                                <div class="space-y-2">
                                    <x-form.input name="start_time" label="Start Time" type="time" value="{{ old('start_time') }}" class="bg-gray-800 border-gray-700 text-gray-200" />
                                    <x-input-error :messages="$errors->get('start_time')" class="mt-1"/>
                                </div>
                                <div class="space-y-2">
                                    <x-form.input name="end_time" label="End Time" type="time" value="{{ old('end_time') }}" class="bg-gray-800 border-gray-700 text-gray-200" />
                                    <x-input-error :messages="$errors->get('end_time')" class="mt-1"/>
                                </div>
                            </div>
                        </div>
                        <x-modal.footer class="bg-gray-900">
                            <x-primary-button type="submit" class="bg-gray-700 hover:bg-gray-600 text-white">
                                Submit
                            </x-primary-button>
                        </x-modal.footer>
                    </x-modal.wrapper>
                </form>            </div>
        </div>

    </x-slot>
    <!-- Card Section -->
    <div class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
        <!-- Grid -->
        <p class="text-cyan-700">Current time: {{ \Carbon\Carbon::now()->format('h:i A') }}</p>
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
            <!-- Card 1: Total Visitors Today -->
            <div class="flex flex-col bg-white border border-gray-200 shadow-2xs rounded-xl dark:bg-neutral-800 dark:border-neutral-700">
                <div class="p-4 md:p-5">
                    <div class="flex items-center justify-between gap-x-2">
                        <div class="flex items-center gap-x-2">
                            <p class="text-xs uppercase text-gray-500 dark:text-neutral-500">
                                Total Visitors Today
                            </p>
                            <div class="hs-tooltip">
                                <div class="hs-tooltip-toggle">
                                    <svg class="shrink-0 size-4 text-gray-500 dark:text-neutral-500" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <circle cx="12" cy="12" r="10"/>
                                        <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/>
                                        <path d="M12 17h.01"/>
                                    </svg>
                                    <span class="hs-tooltip-content hs-tooltip-shown:opacity-100 hs-tooltip-shown:visible opacity-0 transition-opacity inline-block absolute invisible z-10 py-1 px-2 bg-gray-900 text-xs font-medium text-white rounded-md shadow-2xs dark:bg-neutral-700" role="tooltip">
                                    The number of daily users
                                </span>
                                </div>
                            </div>
                        </div>
                        <!-- Eye Icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-eye text-gray-500 dark:text-neutral-500">
                            <path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0"/>
                            <circle cx="12" cy="12" r="3"/>
                        </svg>
                    </div>
                    <div class="mt-1 flex items-center gap-x-2">
                        <h3 class="text-xl sm:text-2xl font-medium text-gray-800 dark:text-neutral-200">
                            {{ $dailyVisitorCount }}
                        </h3>
                    </div>
                </div>
            </div>
            <!-- End Card 1 -->

            <!-- Card 2: Active Visitors Today -->
            <div class="flex flex-col bg-white border border-gray-200 shadow-2xs rounded-xl dark:bg-neutral-800 dark:border-neutral-700">
                <div class="p-4 md:p-5">
                    <div class="flex items-center justify-between gap-x-2">
                        <div class="flex items-center gap-x-2">
                            <p class="text-xs uppercase text-gray-500 dark:text-neutral-500">
                                Active Visitors Today
                            </p>
                            <div class="hs-tooltip">
                                <div class="hs-tooltip-toggle">
                                    <svg class="shrink-0 size-4 text-gray-500 dark:text-neutral-500" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <circle cx="12" cy="12" r="10"/>
                                        <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/>
                                        <path d="M12 17h.01"/>
                                    </svg>
                                    <span class="hs-tooltip-content hs-tooltip-shown:opacity-100 hs-tooltip-shown:visible opacity-0 transition-opacity inline-block absolute invisible z-10 py-1 px-2 bg-gray-900 text-xs font-medium text-white rounded-md shadow-2xs dark:bg-neutral-700" role="tooltip">
                                    The number of active users
                                </span>
                                </div>
                            </div>
                        </div>
                        <!-- Eye Icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-eye text-gray-500 dark:text-neutral-500">
                            <path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0"/>
                            <circle cx="12" cy="12" r="3"/>
                        </svg>
                    </div>
                    <div class="mt-1 flex items-center gap-x-2">
                        <h3 class="text-xl sm:text-2xl font-medium text-gray-800 dark:text-neutral-200">
                            {{ $checkedInVisitorCount }}
                        </h3>
                    </div>
                </div>
            </div>
            <!-- End Card 2 -->

            <!-- Card 3: Overstaying Visitors Today -->
            <div class="flex flex-col bg-white border border-gray-200 shadow-2xs rounded-xl dark:bg-neutral-800 dark:border-neutral-700">
                <div class="p-4 md:p-5">
                    <div class="flex items-center justify-between gap-x-2">
                        <div class="flex items-center gap-x-2">
                            <p class="text-xs uppercase text-gray-500 dark:text-neutral-500">
                                Overstaying Visitors Today
                            </p>
                            <div class="hs-tooltip">
                                <div class="hs-tooltip-toggle">
                                    <svg class="shrink-0 size-4 text-gray-500 dark:text-neutral-500" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <circle cx="12" cy="12" r="10"/>
                                        <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/>
                                        <path d="M12 17h.01"/>
                                    </svg>
                                    <span class="hs-tooltip-content hs-tooltip-shown:opacity-100 hs-tooltip-shown:visible opacity-0 transition-opacity inline-block absolute invisible z-10 py-1 px-2 bg-gray-900 text-xs font-medium text-white rounded-md shadow-2xs dark:bg-neutral-700" role="tooltip">
                                    The number of overstaying users
                                </span>
                                </div>
                            </div>
                        </div>
                        <!-- Eye Icon -->
                        <button type="button" aria-haspopup="dialog" aria-expanded="false" aria-controls="hs-basic-modal" data-hs-overlay="#hs-basic-modal">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-eye text-gray-500 dark:text-neutral-500">
                            <path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0"/>
                            <circle cx="12" cy="12" r="3"/>
                        </svg>
                        </button>
                    </div>
                    <div class="mt-1 flex items-center gap-x-2">
                        <h3 class="text-xl sm:text-2xl font-medium text-gray-800 dark:text-neutral-200">
                            {{ $overstayingVisitorCount }}
                        </h3>
                    </div>
                </div>
            </div>
            <!-- End Card 3 -->
        </div>
        <!-- End Grid -->
    </div>
    <!-- Button to Open the Modal -->


    <!-- Updated Modal with Scroll Effect and Visitor List -->
    <div id="hs-basic-modal" class="hs-overlay hidden size-full fixed top-0 start-0 z-[80] overflow-x-hidden overflow-y-auto" role="dialog" tabindex="-1" aria-labelledby="hs-basic-modal-label">
        <div class="hs-overlay-open:mt-7 hs-overlay-open:opacity-100 hs-overlay-open:duration-500 mt-0 opacity-0 ease-out transition-all sm:max-w-lg sm:w-full m-3 sm:mx-auto h-[calc(100%-56px)]">
            <div class="max-h-full overflow-hidden flex flex-col bg-white border border-gray-200 shadow-2xs rounded-xl pointer-events-auto dark:bg-neutral-800 dark:border-neutral-700 dark:shadow-neutral-700/70">
                <!-- Modal Header -->
                <div class="flex justify-between items-center py-3 px-4 border-b border-gray-200 dark:border-neutral-700">
                    <h3 id="hs-basic-modal-label" class="font-bold text-gray-800 dark:text-white">
                        Visitors List
                    </h3>
                    <button type="button" class="size-8 inline-flex justify-center items-center gap-x-2 rounded-full border border-transparent bg-gray-100 text-gray-800 hover:bg-gray-200 focus:outline-none focus:bg-gray-200 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-700 dark:hover:bg-neutral-600 dark:text-neutral-400 dark:focus:bg-neutral-600" aria-label="Close" data-hs-overlay="#hs-basic-modal">
                        <span class="sr-only">Close</span>
                        <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M18 6 6 18"></path>
                            <path d="m6 6 12 12"></path>
                        </svg>
                    </button>
                </div>
                <!-- Modal Body with Scroll -->
                <div class="p-4 overflow-y-auto">
                    <!-- Filter Input -->
                    <div class="mb-4">
                        <input type="text" id="visitor-filter" placeholder="Search visitors..." class="w-full py-2 px-3 rounded-lg border border-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-neutral-800 dark:border-neutral-700 dark:text-white dark:placeholder-neutral-400">
                    </div>
                    <!-- Visitor Table -->
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-neutral-700">
                        <thead>
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase dark:text-neutral-400">Name</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase dark:text-neutral-400">Visit End Time</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase dark:text-neutral-400">Host</th>
                        </tr>
                        </thead>
                        <tbody id="visitor-table-body" class="divide-y divide-gray-200 dark:divide-neutral-700">
                        @foreach ($checkedInVisitors as $visitor)
                            <tr class="visitor-row">
                                <td class="px-4 py-2 whitespace-nowrap">
                <span class="block text-sm font-semibold text-gray-800 dark:text-neutral-200">
                    {{ $visitor->first_name ?? 'Null' }} {{ $visitor->last_name ?? 'Null' }}
                </span>
                                    <span class="block text-sm text-gray-500 dark:text-neutral-500">
                                        {{ $visitor->telephone ?? 'Null' }}
                                    </span>
                                </td>
                                <td class="px-4 py-2 whitespace-nowrap">
                <span class="block text-sm font-semibold text-gray-800 dark:text-neutral-200">
                     {{ \Carbon\Carbon::parse($visitor->end_time)->format('h:i A') }}
                </span>
                                </td>
                                <td class="px-4 py-2 whitespace-nowrap">
                <span class="block text-sm font-semibold text-gray-800 dark:text-neutral-200">
                    {{ $visitor->user->user_details->school_id ?? 'Null' }}
                </span>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- Modal Footer -->
                <div class="flex justify-end items-center gap-x-2 py-3 px-4 border-t border-gray-200 dark:border-neutral-700">
                    <button type="button" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-2xs hover:bg-gray-50 focus:outline-none focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-700 dark:focus:bg-neutral-700" data-hs-overlay="#hs-basic-modal">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- Use a dark background for the entire page -->
    <div class="py-12 bg-primary text-white min-h-screen">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden shadow-sm sm:rounded-lg">

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
                                                Visit Date: {{ \Carbon\Carbon::parse($allVisitor->visit_date)->format('M d') }}
                                            </p>
                                            <p class="text-sm text-gray-400 mt-2">
                                                Time: {{ \Carbon\Carbon::parse($allVisitor->start_time)->format('h:i A') }} - {{ \Carbon\Carbon::parse($allVisitor->end_time)->format('h:i A') }}
                                            </p>
                                            <p class="mt-2">
                                                <x-status-badge status="{{ $allVisitor->status }}"/>
                                            </p>

                                            <!-- Status actions -->
                                            <div class="mt-3">
                                                @if($allVisitor->status == 'pending')
                                                    @if(auth()->user()?->user_details?->role === 'HR Admin' || auth()->user()?->user_details?->role === 'super admin')
                                                        <!-- Approve Form -->
                                                        <form action="{{ route('visitors.update', $allVisitor->id) }}"
                                                              method="POST" class="inline">
                                                            @csrf
                                                            @method('PATCH')
                                                            <input type="hidden" name="status" value="approved">
                                                            <input type="hidden" name="redirect_to"
                                                                   value="{{ route('dashboard') }}">
                                                            <x-primary-button
                                                                class="bg-green-600 hover:bg-green-700 text-white">
                                                                Approve
                                                            </x-primary-button>
                                                        </form>

                                                        <!-- Deny Form -->
                                                        <form action="{{ route('visitors.update', $allVisitor->id) }}"
                                                              method="POST" class="inline ml-2">
                                                            @csrf
                                                            @method('PATCH')
                                                            <input type="hidden" name="status" value="denied">
                                                            <input type="hidden" name="redirect_to"
                                                                   value="{{ route('dashboard') }}">
                                                            <x-primary-button
                                                                class="bg-red-600 hover:bg-red-700 text-white">
                                                                Deny
                                                            </x-primary-button>
                                                        </form>
                                                    @endif
                                                @elseif($allVisitor->status == 'approved')
                                                    <!-- Check-in Form -->
                                                    <form action="{{ route('visitors.update', $allVisitor->id) }}"
                                                          method="POST" class="inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="status" value="checked_in">
                                                        <input type="hidden" name="redirect_to"
                                                               value="{{ route('dashboard') }}">

                                                        <div class="flex items-center gap-2 mb-4">
                                                            <x-primary-button
                                                                class="bg-gray-700 hover:bg-gray-600 text-white">
                                                                Check In
                                                            </x-primary-button>
                                                        </div>
                                                        <div>
                                                            <label for="visitor_code"
                                                                   class="block text-sm font-medium mb-2">
                                                                Enter Visitor Code
                                                            </label>
                                                            <div
                                                                class="py-2 px-3 bg-brand-900 border border-brand-700 rounded-lg">
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
                                                    <form action="{{ route('visitors.update', $allVisitor->id) }}"
                                                          method="POST" class="inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="status" value="checked_out">
                                                        <input type="hidden" name="redirect_to"
                                                               value="{{ route('dashboard') }}">
                                                        <x-primary-button
                                                            class="bg-gray-700 hover:bg-gray-600 text-white">
                                                            Check Out
                                                        </x-primary-button>
                                                    </form>
                                                @elseif($allVisitor->status == 'denied')
                                                    <span class="text-red-400">Visitor denied</span>
                                                @endif
                                            </div>
                                        </div>
                                        <a href="{{ route('visitors.timeline', $allVisitor->id) }}">
                                            <svg class="shrink-0 size-5 text-gray-300"
                                                 xmlns="http://www.w3.org/2000/svg"
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
                                            Visit Date: {{ \Carbon\Carbon::parse($allVisitor->visit_date)->format('M d') }}
                                        </p>
                                        <p class="text-sm text-gray-400 mt-2">
                                            Time: {{ \Carbon\Carbon::parse($allVisitor->start_time)->format('h:i A') }} - {{ \Carbon\Carbon::parse($allVisitor->end_time)->format('h:i A') }}
                                        </p>

                                        <p class="mt-2">
                                            <x-status-badge status="{{ $myVisitor->status ?? 'Null' }}"/>
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
