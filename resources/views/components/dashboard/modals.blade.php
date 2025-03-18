@props(['totalVisitors', 'checkedInVisitors', 'overstayingVisitors'])

<!-- Modal for Total Visitors -->
<x-dashboard.modal id="hs-total-visitors-modal" title="Total Visitors Today">
    @include('dashboard.partials.visitor-table', ['visitors' => $totalVisitors, 'columns' => ['Name', 'Visit Date', 'Host']])
</x-dashboard.modal>

<!-- Modal for Active Visitors -->
<x-dashboard.modal id="hs-basic-modal" title="Visitors List">
    @include('dashboard.partials.visitor-table', ['visitors' => $checkedInVisitors, 'columns' => ['Name', 'Visit End Time', 'Host']])
</x-dashboard.modal>

<!-- Modal for Overstaying Visitors -->
<x-dashboard.modal id="hs-overstaying-modal" title="Overstaying Visitors">
    @include('dashboard.partials.visitor-table', ['visitors' => $overstayingVisitors, 'columns' => ['Name', 'Visit End Time', 'Host']])
</x-dashboard.modal>
