<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <!-- Title on the left -->
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Admin Panel') }}
            </h2>
        </div>
    </x-slot>

    <!-- Dashboard Cards -->
    <div class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto bg-primary">
        @if(session('status'))
            <p style="color:green;">{{ session('status') }}</p>
        @endif

        <form action="{{ route('settings.update') }}" method="POST">
            @csrf
            <label>Visitor Start Time (HH:MM):</label>
            <input type="time" name="visitor_start_time" value="{{ $settings->visitor_start_time }}">
            <br><br>

            <label>Visitor End Time (HH:MM):</label>
            <input type="time" name="visitor_end_time" value="{{ $settings->visitor_end_time }}">
            <br><br>

            <button type="submit">Save</button>
        </form>
    </div>
</x-app-layout>
