<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-neutral-200 leading-tight">
            {{ __('Inventory Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <!-- Carousel and Details -->
        <div class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
            <div class="grid sm:grid-cols-2 sm:items-center gap-8">

                <!-- Carousel (right side) -->
                <div class="sm:order-2 relative">
                    <div data-hs-carousel='{
          "isAutoHeight": true,
          "loadingClasses": "opacity-0",
          "dotsItemClasses": "hs-carousel-active:bg-blue-700 hs-carousel-active:border-blue-700 size-3 border border-gray-400 rounded-full cursor-pointer dark:border-neutral-600 dark:hs-carousel-active:bg-blue-500 dark:hs-carousel-active:border-blue-500"
        }' class="relative">
                        <div class="hs-carousel relative overflow-hidden w-full bg-transparent rounded-lg">
                            <div class="hs-carousel-body flex flex-nowrap overflow-hidden transition-[height,transform] duration-700 opacity-0">

                                <!-- First Slide -->
                                <div class="hs-carousel-slide h-80 lg:h-96">
                                    <div class="bg-no-repeat bg-center bg-contain h-full w-full"
                                         style="background-image: url('{{ asset('storage/appliance_images/1.jpeg') }}')">
                                    </div>
                                </div>

                                <!-- Second Slide -->
                                <div class="hs-carousel-slide h-80 lg:h-96">
                                    <div class="bg-no-repeat bg-center bg-contain h-full w-full"
                                         style="background-image: url('{{ asset('storage/appliance_images/2.jpeg') }}')">
                                    </div>
                                </div>

                                <!-- Third Slide -->
                                <div class="hs-carousel-slide h-80 lg:h-96">
                                    <div class="bg-no-repeat bg-center bg-contain h-full w-full"
                                         style="background-image: url('{{ asset('storage/appliance_images/3.jpeg') }}')">
                                    </div>
                                </div>

                            </div>
                        </div>

                        <button type="button" class="hs-carousel-prev hs-carousel-disabled:opacity-50 hs-carousel-disabled:pointer-events-none absolute inset-y-0 start-0 inline-flex justify-center items-center w-11.5 h-full text-gray-800 hover:bg-gray-800/10 focus:outline-hidden focus:bg-gray-800/10 rounded-s-lg dark:text-white dark:hover:bg-white/10 dark:focus:bg-white/10">
          <span class="text-2xl" aria-hidden="true">
            <svg class="shrink-0 size-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="m15 18-6-6 6-6"></path>
            </svg>
          </span>
                            <span class="sr-only">Previous</span>
                        </button>

                        <button type="button" class="hs-carousel-next hs-carousel-disabled:opacity-50 hs-carousel-disabled:pointer-events-none absolute inset-y-0 end-0 inline-flex justify-center items-center w-11.5 h-full text-gray-800 hover:bg-gray-800/10 focus:outline-hidden focus:bg-gray-800/10 rounded-e-lg dark:text-white dark:hover:bg-white/10 dark:focus:bg-white/10">
                            <span class="sr-only">Next</span>
                            <span class="text-2xl" aria-hidden="true">
            <svg class="shrink-0 size-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="m9 18 6-6-6-6"></path>
            </svg>
          </span>
                        </button>

                        <div class="hs-carousel-pagination flex justify-center absolute bottom-3 start-0 end-0 gap-x-2"></div>
                    </div>
                </div>

                <!-- Details (left side) -->
                <div class="sm:order-1">
                    <h2 class="text-2xl font-bold md:text-3xl lg:text-4xl text-gray-800 dark:text-neutral-200">
                       Details
                    </h2>

                    <p class="mt-5 text-gray-600 dark:text-neutral-400">
                        Appliance Name: {{$inventory->appliance_name}}
                    </p>
                    <p class="mt-5 text-gray-600 dark:text-neutral-400">
                        Owner: {{$inventory->user->first_name}} {{$inventory->user->last_name}}
                    </p>
                    <p class="mt-2 text-gray-600 dark:text-neutral-400">
                        School ID: {{$inventory->user->user_details->school_id}}
                    </p>
                    <p class="mt-2 text-gray-600 dark:text-neutral-400">
                        Location: {{$inventory->location}}
                    </p>
                    <p class="mt-2 text-gray-600 dark:text-neutral-400">
                        Status:   <x-status-badge status="{{ $inventory->status }}"/>
                    </p>

                </div>
            </div>
        </div>
        <!-- End Carousel and Details -->    </div>
</x-app-layout>
