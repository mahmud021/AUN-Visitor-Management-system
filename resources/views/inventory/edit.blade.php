<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Inventory: ') }}{{ $inventory->appliance_name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <!-- Main container -->
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Inventory Information Update Section -->
            <div class="p-4 sm:p-8 bg-brand-900 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                {{ __('Inventory Information') }}
                            </h2>
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                {{ __('Update the inventory’s appliance name, brand, location, status, and image.') }}
                            </p>
                        </header>

                        <form method="post" action="{{ route('inventory.update', $inventory->id) }}" enctype="multipart/form-data" class="mt-6 space-y-6">
                            @csrf
                            @method('patch')

                            <!-- Appliance Name -->
                            <div>
                                <x-input-label for="appliance_name" :value="__('Appliance Name')"/>
                                <x-text-input id="appliance_name" name="appliance_name" type="text" class="mt-1 block w-full"
                                              :value="old('appliance_name', $inventory->appliance_name)" required autofocus/>
                                <x-input-error class="mt-2" :messages="$errors->get('appliance_name')"/>
                            </div>

                            <!-- Brand -->
                            <div>
                                <x-input-label for="brand" :value="__('Brand')"/>
                                <x-text-input id="brand" name="brand" type="text" class="mt-1 block w-full"
                                              :value="old('brand', $inventory->brand)" required/>
                                <x-input-error class="mt-2" :messages="$errors->get('brand')"/>
                            </div>

                            <!-- Location -->
                            <div>
                                <x-form.select name="location" label="Location">
                                    <option value="" disabled {{ old('location', $inventory->location) ? '' : 'selected' }}>Select a location</option>
                                    @foreach($locations as $location)
                                        <option value="{{ $location->name }}" {{ old('location', $inventory->location) == $location->name ? 'selected' : '' }}>
                                            {{ $location->name }}
                                        </option>
                                    @endforeach
                                </x-form.select>
                                <x-input-error :messages="$errors->get('location')" class="mt-1 text-brand-400"/>
                            </div>


                            <!-- Image Upload -->
                            <div>
                                <x-input-label for="image_path" :value="__('Image')"/>
                                <x-text-input id="image_path" name="image_path" type="file" class="mt-1 block w-full"/>
                                <x-input-error class="mt-2" :messages="$errors->get('image_path')"/>
                            </div>

                            <!-- Save Button -->
                            <div class="flex items-center gap-4">
                                <x-primary-button>{{ __('Save') }}</x-primary-button>
                                @if (session('success'))
                                    <p x-data="{ show: true }"
                                       x-show="show"
                                       x-transition
                                       x-init="setTimeout(() => show = false, 2000)"
                                       class="text-sm text-gray-600 dark:text-gray-400">
                                        {{ session('success') }}
                                    </p>
                                @endif
                            </div>
                        </form>
                    </section>
                </div>
            </div>

            <!-- Delete Inventory Section -->
            <!-- (Optional: Add your delete inventory section here if needed) -->

        </div>
    </div>
</x-app-layout>
