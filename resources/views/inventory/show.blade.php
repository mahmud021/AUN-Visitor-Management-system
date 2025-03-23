<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-neutral-200 leading-tight">
            {{ __('Inventory Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <!-- Carousel and Details -->
        <!-- Carousel and Details (Responsive Grid) -->
        <div class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
            <div class="grid sm:grid-cols-2 sm:items-center gap-8">

                <!-- Carousel (right side) -->
                <div class="sm:order-2">
                    <div class="relative pt-[50%] sm:pt-[100%] rounded-lg overflow-hidden">
                        <div data-hs-carousel='{
          "isAutoHeight": false,
          "loadingClasses": "opacity-0",
          "dotsItemClasses": "hs-carousel-active:bg-blue-700 hs-carousel-active:border-blue-700 size-3 border border-gray-400 rounded-full cursor-pointer dark:border-neutral-600 dark:hs-carousel-active:bg-blue-500 dark:hs-carousel-active:border-blue-500"
        }' class="absolute inset-0 w-full h-full">

                            <div
                                class="hs-carousel-body absolute inset-0 flex flex-nowrap transition-transform duration-700 opacity-0">

                                <!-- First Slide -->
                                <div
                                    class="hs-carousel-slide size-full bg-no-repeat bg-center bg-contain bg-transparent"
                                    style="background-image: url('{{ asset('storage/appliance_images/1.jpeg') }}')">
                                </div>

                                <!-- Second Slide -->
                                <div
                                    class="hs-carousel-slide size-full bg-no-repeat bg-center bg-contain bg-transparent"
                                    style="background-image: url('{{ asset('storage/appliance_images/2.jpeg') }}')">
                                </div>

                                <!-- Third Slide -->
                                <div
                                    class="hs-carousel-slide size-full bg-no-repeat bg-center bg-contain bg-transparent"
                                    style="background-image: url('{{ asset('storage/appliance_images/3.jpeg') }}')">
                                </div>

                            </div>

                            <!-- Carousel navigation -->
                            <button type="button"
                                    class="hs-carousel-prev absolute inset-y-0 start-0 flex items-center justify-center px-4 cursor-pointer">
                                <svg class="size-6 text-gray-700 dark:text-neutral-200"
                                     xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor"
                                     stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="m15 18-6-6 6-6"></path>
                                </svg>
                                <span class="sr-only">Previous</span>
                            </button>

                            <button type="button"
                                    class="hs-carousel-next absolute inset-y-0 end-0 flex items-center justify-center px-4 cursor-pointer">
                                <svg class="size-6 text-gray-700 dark:text-neutral-200"
                                     xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor"
                                     stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="m9 18 6-6-6-6"></path>
                                </svg>
                                <span class="sr-only">Next</span>
                            </button>

                            <div
                                class="hs-carousel-pagination absolute bottom-4 inset-x-0 flex justify-center gap-x-2"></div>
                        </div>
                    </div>
                </div>

                <!-- Details (left side) -->
                <div class="sm:order-1">
                    <h2 class="text-2xl font-bold md:text-3xl lg:text-4xl text-gray-800 dark:text-neutral-200">
                        {{ $inventory->appliance_name }}
                    </h2>

                    <p class="mt-5 text-gray-600 dark:text-neutral-400">
                        <strong>Owner:</strong> {{ $inventory->user->first_name }} {{ $inventory->user->last_name }}
                    </p>
                    <p class="mt-2 text-gray-600 dark:text-neutral-400">
                        <strong>School ID:</strong> {{ $inventory->user->user_details->school_id }}
                    </p>
                    <p class="mt-2 text-gray-600 dark:text-neutral-400">
                        <strong>Location:</strong> {{ $inventory->location }}
                    </p>
                    <p class="mt-2 text-gray-600 dark:text-neutral-400">
                        <strong>Created:</strong> {{ \Carbon\Carbon::parse($inventory->created_at)->format('d M, Y') }}

                    </p>
                    <p class="mt-2 text-gray-600 dark:text-neutral-400">
                        <strong>Status:</strong> <x-status-badge status="{{ $inventory->status }}"/>
                    </p>
                </div>

            </div>
        </div>

        <!-- End Carousel and Details -->
        <!-- Inventory Timeline Table -->
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-10">
            <x-table-wrapper>
                <x-table-header title="Appliance Timeline" description="Check-in and Check-out Details of Appliance.">
                    <x-slot name="actions">
                        <!-- Leave empty if no actions are required -->
                    </x-slot>
                </x-table-header>

                <x-table>
                    <x-slot name="header">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-start">
                        <span class="text-xs font-semibold uppercase tracking-wide text-neutral-200">
                            Checked In Time
                        </span>
                            </th>
                            <th scope="col" class="px-6 py-3 text-start">
                        <span class="text-xs font-semibold uppercase tracking-wide text-neutral-200">
                            Location
                        </span>
                            </th>
                            <th scope="col" class="px-6 py-3 text-start">
                        <span class="text-xs font-semibold uppercase tracking-wide text-neutral-200">
                            Checked Out Time
                        </span>
                            </th>
                            <th scope="col" class="px-6 py-3 text-start">
                        <span class="text-xs font-semibold uppercase tracking-wide text-neutral-200">
                            Status
                        </span>
                            </th>
                        </tr>
                    </x-slot>

                    <x-slot name="rows">
                        <x-table-row>
                            <!-- Checked In Time -->
                            <td class="px-6 py-3 whitespace-nowrap">
                        <span class="text-sm text-neutral-200">
                            {{ $inventory->checked_in_at ? \Carbon\Carbon::parse($inventory->checked_in_at)->format('M d, Y h:i A') : 'N/A' }}
                        </span>
                            </td>

                            <!-- Location -->
                            <td class="px-6 py-3 whitespace-nowrap">
                        <span class="text-sm text-neutral-200">
                            {{ $inventory->location ?? 'Not Specified' }}
                        </span>
                            </td>

                            <!-- Checked Out Time -->
                            <td class="px-6 py-3 whitespace-nowrap">
                        <span class="text-sm text-neutral-200">
                            {{ $inventory->checked_out_at ? \Carbon\Carbon::parse($inventory->checked_out_at)->format('M d, Y h:i A') : 'N/A' }}
                        </span>
                            </td>

                            <!-- Status -->
                            <td class="px-6 py-3 whitespace-nowrap">
                                <x-status-badge status="{{ $inventory->status }}"/>
                            </td>
                        </x-table-row>
                    </x-slot>
                </x-table>

                <x-table-footer totalResults=""/>
            </x-table-wrapper>
        </div>

    </div>
</x-app-layout>
