<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-neutral-200 leading-tight">
            {{ __('Inventory Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Slider -->
            <div data-hs-carousel='{
    "loadingClasses": "opacity-0"
  }' class="relative">
                <div class="hs-carousel flex flex-col md:flex-row gap-2">
                    <div class="md:order-2 relative grow overflow-hidden min-h-96 bg-transparent rounded-lg">
                        <div class="hs-carousel-body absolute top-0 bottom-0 start-0 flex flex-nowrap transition-transform duration-700 opacity-0">

                            <!-- First Slide -->
                            <div class="hs-carousel-slide">
                                <div class="bg-no-repeat bg-center bg-contain h-full w-full"
                                     style="background-image: url('{{ asset('storage/appliance_images/1.jpeg') }}')">
                                </div>
                            </div>

                            <!-- Second Slide -->
                            <div class="hs-carousel-slide">
                                <div class="bg-no-repeat bg-center bg-contain h-full w-full"
                                     style="background-image: url('{{ asset('storage/appliance_images/2.jpeg') }}')">
                                </div>
                            </div>

                            <!-- Third Slide -->
                            <div class="hs-carousel-slide">
                                <div class="bg-no-repeat bg-center bg-contain h-full w-full"
                                     style="background-image: url('{{ asset('storage/appliance_images/3.jpeg') }}')">
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
                    </div>

                    <div class="md:order-1 flex-none">
                        <div class="hs-carousel-pagination max-h-96 flex flex-row md:flex-col gap-2 overflow-x-auto md:overflow-x-hidden md:overflow-y-auto">

                            <!-- First Thumbnail -->
                            <div class="hs-carousel-pagination-item shrink-0 border border-gray-200 rounded-md overflow-hidden cursor-pointer size-20 md:size-32 hs-carousel-active:border-blue-400 dark:border-neutral-700">
                                <img src="{{ asset('storage/appliance_images/1.jpeg') }}" alt="First Thumbnail" class="w-full h-full object-cover"/>
                            </div>

                            <!-- Second Thumbnail -->
                            <div class="hs-carousel-pagination-item shrink-0 border border-gray-200 rounded-md overflow-hidden cursor-pointer size-20 md:size-32 hs-carousel-active:border-blue-400 dark:border-neutral-700">
                                <img src="{{ asset('storage/appliance_images/2.jpeg') }}" alt="Second Thumbnail" class="w-full h-full object-cover"/>
                            </div>

                            <!-- Third Thumbnail -->
                            <div class="hs-carousel-pagination-item shrink-0 border border-gray-200 rounded-md overflow-hidden cursor-pointer size-20 md:size-32 hs-carousel-active:border-blue-400 dark:border-neutral-700">
                                <img src="{{ asset('storage/appliance_images/3.jpeg') }}" alt="Third Thumbnail" class="w-full h-full object-cover"/>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
            <!-- End Slider -->
            <!-- Card Blog -->
            <div class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
                <!-- Title -->
                <div class="max-w-xl mx-auto bg-neutral-800 rounded-xl shadow-lg p-6">
                    <h2 class="text-2xl font-bold md:text-3xl text-center text-neutral-200 mb-6">Appliance Details</h2>

                    <div class="space-y-4">
                        <div class="flex justify-between items-center border-b border-neutral-700 pb-2">
                            <span class="text-sm font-medium text-neutral-400">Appliance Name:</span>
                            <span class="text-sm text-neutral-200">{{$inventory->appliance_name}}</span>
                        </div>

                        <div class="flex justify-between items-center border-b border-neutral-700 pb-2">
                            <span class="text-sm font-medium text-neutral-400">Owner:</span>
                            <span class="text-sm text-neutral-200">{{$inventory->user->first_name}} {{$inventory->user->last_name}}</span>
                        </div>

                        <div class="flex justify-between items-center border-b border-neutral-700 pb-2">
                            <span class="text-sm font-medium text-neutral-400">School ID:</span>
                            <span class="text-sm text-neutral-200">{{$inventory->user->user_details->school_id}}</span>
                        </div>

                        <div class="flex justify-between items-center border-b border-neutral-700 pb-2">
                            <span class="text-sm font-medium text-neutral-400">Location:</span>
                            <span class="text-sm text-neutral-200">{{$inventory->location}}</span>
                        </div>

                        <div class="flex justify-between items-center">
                            <span class="text-sm font-medium text-neutral-400">Status:</span>
                            <span class="text-sm text-neutral-200">{{$inventory->status}}</span>
                        </div>
                    </div>
                </div>
                <!-- End Title -->
            </div>->
        </div>
    </div>
</x-app-layout>
