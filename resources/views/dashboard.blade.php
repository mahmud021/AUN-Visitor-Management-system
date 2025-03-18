
<x-app-layout>

    <x-slot name="header">
        <!-- Extracted header component -->
        <x-dashboard.header :user="$user" />
    </x-slot>

    <div class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
        <p class="text-cyan-700">Current time: {{ \Illuminate\Support\Carbon::now()->format('h:i A') }}</p>
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
            <!-- Reusable card components -->
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

    <!-- Include modal components -->
    <x-dashboard.modals
        :totalVisitors="$totalVisitors"
        :checkedInVisitors="$checkedInVisitors"
        :overstayingVisitors="$overstayingVisitors" />

    <!-- Dashboard content for all visitors and my visitors -->
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
