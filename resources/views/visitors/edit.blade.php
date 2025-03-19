<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Edit Visitor: {{ $visitor->first_name }} {{ $visitor->last_name }}
        </h2>
        <p class="text-sm text-gray-300">

        </p>

    </x-slot>

    <div class="py-12">
        <!-- Main container -->
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- User Information Update Section -->
            <div class="p-4 sm:p-8  bg-brand-900 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                {{ __('Visitor Information') }}
                            </h2>
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                            </p>
                        </header>

                        <form method="post" action="{{ route('visitors.update', $visitor->id) }}" class="mt-6 space-y-6">
                            @csrf
                            @method('patch')

                            <!-- First Name -->
                            <div>
                                <x-input-label for="first_name" :value="__('First Name')"/>
                                <x-text-input id="first_name" name="first_name" type="text" class="mt-1 block w-full"
                                              :value="old('first_name', $visitor->first_name)" required autofocus/>
                                <x-input-error class="mt-2" :messages="$errors->get('first_name')"/>
                            </div>

                            <!-- Last Name -->
                            <div>
                                <x-input-label for="last_name" :value="__('Last Name')"/>
                                <x-text-input id="last_name" name="last_name" type="text" class="mt-1 block w-full"
                                              :value="old('last_name', $visitor->last_name)" required/>
                                <x-input-error class="mt-2" :messages="$errors->get('last_name')"/>
                            </div>

                            <!-- Telephone -->
                            <div>
                                <x-input-label for="telephone" :value="__('Telephone Number')"/>
                                <x-text-input id="telephone" name="telephone" type="text" class="mt-1 block w-full"
                                              :value="old('telephone', $visitor->telephone)" required/>
                                <x-input-error class="mt-2" :messages="$errors->get('telephone')"/>
                            </div>

                            <!-- Date -->
                            <div>
                                <x-input-label for="visit_date" :value="__('Date')"/>
                                <x-text-input id="visit_date" name="visit_date" type="date" class="mt-1 block w-full"
                                              value="{{ old('visit_date', $visitor->visit_date ? $visitor->visit_date->format('Y-m-d') : '') }}" required/>
                                <x-input-error class="mt-2" :messages="$errors->get('visit_date')"/>
                            </div>

                            <!-- Start Time -->
                            <div>
                                <x-input-label for="start_time" :value="__('Start Time')"/>
                                <x-text-input id="start_time" name="start_time" type="time" class="mt-1 block w-full"
                                              value="{{ old('start_time', $visitor->start_time ? $visitor->start_time->format('H:i') : '') }}" required/>
                                <x-input-error class="mt-2" :messages="$errors->get('start_time')"/>
                            </div>

                            <!-- End Time -->
                            <div>
                                <x-input-label for="end_time" :value="__('End Time')"/>
                                <x-text-input id="end_time" name="end_time" type="time" class="mt-1 block w-full"
                                              value="{{ old('end_time', $visitor->end_time ? $visitor->end_time->format('H:i') : '') }}" required/>
                                <x-input-error class="mt-2" :messages="$errors->get('end_time')"/>
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

            <!-- Delete User Section -->
            <div class="p-4 sm:p-8 bg-brand-900 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <section class="space-y-6">
                        <header>
                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                {{ __('Delete User') }}
                            </h2>
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                {{ __('Deleting this user will remove all associated data. Please confirm deletion by entering your password.') }}
                            </p>
                        </header>

                        <!-- Delete button triggers the modal -->
                        <x-danger-button x-data=""
                                         x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')">
                            {{ __('Delete User') }}
                        </x-danger-button>

                        <!-- Modal for deletion confirmation -->
                        <x-modal name="confirm-user-deletion" :show="$errors->has('userDeletion')" focusable>
                            <form method="post" action="{{ route('user.destroy', $visitor->id) }}" class="p-6">
                                @csrf
                                @method('delete')

                                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                    {{ __('Are you sure you want to delete this user?') }}
                                </h2>
                                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                    {{ __('Once deleted, all of the user’s data will be permanently removed.') }}
                                </p>

                                <div class="mt-6">
                                    <x-input-label for="password" :value="__('Password')" class="sr-only"/>
                                    <x-text-input id="password" name="password" type="password"
                                                  class="mt-1 block w-3/4"
                                                  placeholder="{{ __('Password') }}"/>
                                    <x-input-error :messages="$errors->get('userDeletion')" class="mt-2"/>
                                </div>

                                <div class="mt-6 flex justify-end">
                                    <x-secondary-button x-on:click="$dispatch('close')">
                                        {{ __('Cancel') }}
                                    </x-secondary-button>
                                    <x-danger-button class="ml-3">
                                        {{ __('Delete User') }}
                                    </x-danger-button>
                                </div>
                            </form>
                        </x-modal>
                    </section>
                </div>
            </div>

        </div>
    </div>

</x-app-layout>
