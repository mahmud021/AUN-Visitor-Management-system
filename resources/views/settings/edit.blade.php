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
        <h3 class="font-semibold text-lg text-white">
            Time Window
        </h3>

        <form action="{{ route('settings.update') }}" method="POST" class="space-y-6">
            @csrf

            <div class="flex space-x-4">
                <!-- Start Time -->
                <div class="space-y-2 max-w-32">
                    <x-form.input
                        name="visitor_start_time"
                        label="Start Time"
                        type="time"
                        :value="old('visitor_start_time', $settings->visitor_start_time ?? \Carbon\Carbon::now()->format('H:i'))"
                        class="bg-brand-800 border-brand-700 text-brand-100 placeholder-brand-300"
                    />
                    <x-input-error :messages="$errors->get('visitor_start_time')" class="mt-1 text-brand-400"/>
                </div>

                <!-- End Time -->
                <div class="space-y-2 max-w-32">
                    <x-form.input
                        name="visitor_end_time"
                        label="End Time"
                        type="time"
                        :value="old('visitor_end_time', $settings->visitor_end_time ?? \Carbon\Carbon::now()->addHour()->format('H:i'))"
                        class="bg-brand-800 border-brand-700 text-brand-100 placeholder-brand-300"
                    />
                    <x-input-error :messages="$errors->get('visitor_end_time')" class="mt-1 text-brand-400"/>
                </div>
            </div>

            <x-primary-button type="submit" class="bg-brand-700 hover:bg-brand-600 text-white">
                Save
            </x-primary-button>
        </form>    </div>
</x-app-layout>
