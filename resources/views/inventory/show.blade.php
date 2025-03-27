<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-neutral-200 leading-tight">
            {{ __('Inventory Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <!-- Carousel and Details -->
        <div class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
            <div class="grid sm:grid-cols-2 sm:items-start gap-8">
                <!-- Left Column: Item Details -->
                <div>
                    <div class="px-4 sm:px-0">
                        <h3 class="text-base/7 font-semibold text-brand-50"></h3>
                        <p class="mt-1 max-w-2xl text-sm/6 text-brand-300">Item details.</p>
                    </div>
                    <div class="mt-6 border-t border-brand-800 ">
                        <dl class="divide-y divide-brand-800">
                            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                <dt class="text-sm/6 font-medium text-brand-50">Owner Name</dt>
                                <dd class="mt-1 text-sm/6 text-brand-200 sm:col-span-2 sm:mt-0">
                                    {{$inventory->user->first_name ?? 'Null' }}  {{$inventory->user->last_name ?? 'Null' }}
                                    <p>{{$inventory->user->user_details->school_id}}</p>
                                </dd>
                            </div>
                            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                <dt class="text-sm/6 font-medium text-brand-50">Appliance Name</dt>
                                <dd class="mt-1 text-sm/6 text-brand-200 sm:col-span-2 sm:mt-0">
                                    {{$inventory->appliance_name ?? 'Null' }}
                                </dd>
                            </div>
                            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                <dt class="text-sm/6 font-medium text-brand-50">Appliance Brand</dt>
                                <dd class="mt-1 text-sm/6 text-brand-200 sm:col-span-2 sm:mt-0">
                                    {{$inventory->brand ?? 'Null' }}
                                </dd>
                            </div>
                            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                <dt class="text-sm/6 font-medium text-brand-50">Current Location</dt>
                                <dd class="mt-1 text-sm/6 text-brand-200 sm:col-span-2 sm:mt-0">
                                    {{$inventory->location ?? 'Null' }}
                                </dd>
                            </div>

                            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                <dt class="text-sm/6 font-medium text-brand-50">Status</dt>
                                <dd class="mt-1 text-sm/6 text-brand-200 sm:col-span-2 sm:mt-0">
                                    <x-status-badge status="{{ $inventory->status ?? 'Null' }}" />
                                </dd>
                            </div>
                            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                <dt class="text-sm/6 font-medium text-brand-50">Created</dt>
                                <dd class="mt-1 text-sm/6 text-brand-200 sm:col-span-2 sm:mt-0">
                                    {{ \Carbon\Carbon::parse($inventory->created_at)->format('d M, Y') }}
                                </dd>
                            </div>
                            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                <dt class="text-sm/6 font-medium text-brand-50">Action Button</dt>
                            @if($inventory->status === 'pending')
                                    {{-- Show "Check In" button if status is "pending" --}}
                                    <form action="{{ route('inventory.update', $inventory->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="checked_in">
                                        <x-primary-button>
                                            Check In
                                            </x-primary-button>
                                    </form>

                                @elseif($inventory->status === 'checked_in')
                                    {{-- Show "Check Out" button if status is "checked_in" --}}
                                    <form action="{{ route('inventory.update', $inventory->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="checked_out">
                                        <x-primary-button>
                                            Check Out
                                            </x-primary-button>
                                    </form>

                                @elseif($inventory->status === 'checked_out')
                                    {{-- Show "Check In" button again if status is "checked_out" --}}
                                    <form action="{{ route('inventory.update', $inventory->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="checked_in">
                                        <x-primary-button>
                                            Check In
                                            </x-primary-button>
                                    </form>
                                @endif
                            </div>

                            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                <dt class="text-sm/6 font-medium text-brand-50"></dt>
                                <dd class="mt-1 text-sm/6 text-brand-200 sm:col-span-2 sm:mt-0">
                                    <a
                                        href="{{ route('inventory.timeline', $inventory->id) }}"
                                        class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent
                   rounded-md font-semibold text-xs text-white uppercase tracking-widest
                   hover:bg-indigo-500 active:bg-indigo-700 focus:outline-none focus:border-indigo-700
                   focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150"
                                    >
                                        View Item Timeline
                                    </a>
                                </dd>
                            </div>



                        </dl>
                    </div>
                </div>

                <!-- Right Column: Item Image -->
                <div class="flex justify-center sm:justify-end items-start">
                    <div class="max-w-sm w-full">
                        <!-- Adjust the `asset('...')` part to match the actual path to your image -->
                        @if(!empty($inventory->image_path))
                            <img
                                src="{{ asset('storage/' . $inventory->image_path) }}"
                                alt="Item Image"
                                class="rounded-lg shadow-md object-cover w-full h-auto"
                            >
                        @else
                            <img
                                src="{{ asset('images/placeholder.png') }}"
                                alt="No Image"
                                class="rounded-lg shadow-md object-cover w-full h-auto"
                            >
                        @endif

                    </div>
                </div>
            </div>
        </div>
        <!-- End Carousel and Details -->

        <!-- Inventory Timeline Table -->
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-10">

        </div>
    </div>
</x-app-layout>
