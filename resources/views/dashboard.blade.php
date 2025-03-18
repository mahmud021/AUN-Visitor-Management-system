<x-app-layout>
    <x-slot name="header">
        <!-- Header with Create Visitor and Logout buttons -->
        <x-dashboard.header :user="$user" />
    </x-slot>

    <!-- Dashboard Cards -->
    <div class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
        <p class="text-cyan-700">
            Current time: {{ \Illuminate\Support\Carbon::now()->format('h:i A') }}
        </p>
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
            <x-dashboard.card
                title="Total Visitors Today"
                :count="$dailyVisitorCount"
                tooltip="The number of visitors today"
                modal-target="hs-total-visitors-modal" />

            <x-dashboard.card
                title="Active Visitors Today"
                :count="$checkedInVisitorCount"
                tooltip="The number of active users"
                modal-target="hs-basic-modal" />

            <x-dashboard.card
                title="Overstaying Visitors Today"
                :count="$overstayingVisitorCount"
                tooltip="The number of overstaying users"
                modal-target="hs-overstaying-modal" />
        </div>
    </div>

    <!-- Create Visitor Modal -->
    <!-- Create Visitor Modal -->
    <form method="POST" action="{{ route('visitors.store') }}" onsubmit="disableSubmitButton(this)">
        @csrf
        <x-modal.wrapper id="hs-scale-animation-modal">
            <x-modal.header title="Create Visitor" modalId="hs-scale-animation-modal" />
            <div class="p-4 overflow-y-auto bg-brand-900 text-gray-100">
                <div class="grid grid-cols-2 gap-4 lg:gap-4">
                    <!-- First Name -->
                    <div class="space-y-2">
                        <x-form.input name="first_name" label="First Name" type="text"
                                      value="{{ old('first_name') }}"
                                      class="bg-gray-800 border-gray-700 text-gray-200"/>
                        <x-input-error :messages="$errors->get('first_name')" class="mt-1"/>
                    </div>

                    <!-- Last Name -->
                    <div class="space-y-2">
                        <x-form.input name="last_name" label="Last Name" type="text"
                                      value="{{ old('last_name') }}"
                                      class="bg-gray-800 border-gray-700 text-gray-200"/>
                        <x-input-error :messages="$errors->get('last_name')" class="mt-1"/>
                    </div>

                    <!-- Telephone Number -->
                    <div class="space-y-2">
                        <x-form.input name="telephone" label="Telephone Number" type="text"
                                      value="{{ old('telephone') }}"
                                      class="bg-gray-800 border-gray-700 text-gray-200"/>
                        <x-input-error :messages="$errors->get('telephone')" class="mt-1"/>
                    </div>

                    <!-- Visit Date -->
                    <div class="space-y-2">
                        <x-form.input name="visit_date" label="Visit Date" type="date"
                                      value="{{ old('visit_date', \Carbon\Carbon::now()->toDateString()) }}"
                                      class="bg-gray-800 border-gray-700 text-gray-200"/>
                        <x-input-error :messages="$errors->get('visit_date')" class="mt-1"/>
                    </div>

                    <!-- Start Time -->
                    <div class="space-y-2">
                        <x-form.input name="start_time" label="Start Time" type="time"
                                      value="{{ old('start_time', \Carbon\Carbon::now()->format('H:i')) }}"
                                      class="bg-gray-800 border-gray-700 text-gray-200"/>
                        <x-input-error :messages="$errors->get('start_time')" class="mt-1"/>
                    </div>

                    <!-- End Time -->
                    <div class="space-y-2">
                        <x-form.input name="end_time" label="End Time" type="time"
                                      value="{{ old('end_time', \Carbon\Carbon::now()->addHour()->format('H:i')) }}"
                                      class="bg-gray-800 border-gray-700 text-gray-200"/>
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
    </form>

    <script>
        function disableSubmitButton(form) {
            const submitButton = form.querySelector('button[type="submit"], input[type="submit"], x-primary-button');
            if (submitButton) {
                submitButton.disabled = true;
                submitButton.innerText = 'Submitting...';
            }
        }
    </script>


    <!-- Other Modals (Total Visitors, Active Visitors, Overstaying Visitors) -->
    <x-dashboard.modals
        :totalVisitors="$totalVisitors"
        :checkedInVisitors="$checkedInVisitors"
        :overstayingVisitors="$overstayingVisitors" />

    <!-- Additional Dashboard Content -->
    <div class="py-12 bg-primary text-white min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden shadow-sm sm:rounded-lg">
                @can('view-all-visitors')
                    @include('dashboard.allVisitors')
                @endcan

                @include('dashboard.myVisitors')
            </div>
        </div>
    </div>
</x-app-layout>
