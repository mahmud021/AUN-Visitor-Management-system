<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Analytics Dashboard') }}
        </h2>
    </x-slot>

    <!-- Push ApexCharts CSS to the styles stack -->
    @push('styles')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/apexcharts@3.35.3/dist/apexcharts.css">
    @endpush

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Grid Container -->
            <div class="grid grid-cols-1 md:grid-cols-6 gap-4">
                <!-- Total Visitors Card -->
                <div class="md:col-span-2 p-4 shadow rounded border border-brand-300 bg-transparent text-white">
                    <h3 class="font-bold text-lg">Total Visitors</h3>
                    <canvas id="totalVisitorsChart"></canvas>
                </div>

                <!-- Status Breakdown Card -->
                <div class="md:col-span-2 md:col-start-3 p-4 shadow rounded border border-brand-300 bg-transparent text-white">
                    <h3 class="font-bold text-lg">Status Breakdown</h3>
                    <canvas id="statusBreakdownChart"></canvas>
                </div>

                <!-- Daily Trends Card -->
                <div class="md:col-span-2 md:col-start-5 p-4 shadow rounded border border-brand-300 bg-transparent text-white">
                    <h3 class="font-bold text-lg">Daily Trends</h3>
                    <canvas id="dailyTrendsChart"></canvas>
                </div>

                <!-- Main Detailed Analytics: Daily Visitors -->
                <div class="md:col-span-4 md:row-span-3 md:row-start-2 p-4 shadow rounded border border-brand-300 bg-transparent text-white">
                    <h3 class="font-bold text-lg">Detailed Analytics: Daily Visitors</h3>
                    <p class="text-sm text-gray-300">
                        Total Visitors : {{ $totalVisitors }}
                    </p>
                    <div id="hs-multiple-area-charts"></div>
                </div>

                <!-- Widget 1 -->
                <div class="md:col-span-2 md:row-span-3 md:col-start-5 md:row-start-2 p-4 shadow rounded border border-brand-300 bg-transparent text-white">
                    <h3 class="font-bold text-lg">Widget 1</h3>
                    <!-- Add your widget content here -->
                </div>

                <!-- Widget 2 -->
                <div class="md:col-span-3 md:row-span-3 md:row-start-5 p-4 shadow rounded border border-brand-300 bg-transparent text-white">
                    <h3 class="font-bold text-lg">Widget 2</h3>
                    <!-- Add your widget content here -->
                </div>

                <!-- Widget 3 -->
                <div class="md:col-span-3 md:row-span-3 md:col-start-4 md:row-start-5 p-4 shadow rounded border border-brand-300 bg-transparent text-white">
                    <h3 class="font-bold text-lg">Widget 3</h3>
                    <!-- Add your widget content here -->
                </div>
            </div>
        </div>
    </div>
    <div class="mb-6 p-4 bg-gray-800 text-white rounded">
        <h3 class="font-bold mb-2">Daily Visitor Counts (Debug)</h3>
        <ul>
            @foreach ($datesOfWeek as $index => $date)
                <li>
                    <strong>{{ $labels[$index] }}</strong> ({{ $date }}):
                    <span>{{ $chartData[$index] }}</span>
                </li>
            @endforeach
        </ul>
    </div>


    <!-- Push JavaScript dependencies to the scripts stack -->

    <script>
        window.chartData = @json($chartData);
        window.labels = @json($labels);
        window.datesOfWeek = @json($datesOfWeek);
    </script>
    <script src="https://preline.co/assets/js/hs-apexcharts-helpers.js"></script>

@push('scripts')
        @vite('resources/js/analytics.js')
    @endpush



</x-app-layout>
