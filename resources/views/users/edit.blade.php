<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit User: ') }}{{ $user->first_name }} {{ $user->last_name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <!-- Main container -->
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- User Information Update Section -->
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                {{ __('User Information') }}
                            </h2>
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                {{ __('Update the user’s first name, last name, email, and details.') }}
                            </p>
                        </header>

                        <!-- Form for updating user information -->
                        <form method="post" action="{{ route('user.update', $user->id) }}" class="mt-6 space-y-6">
                            @csrf
                            @method('patch')

                            <!-- First Name -->
                            <div>
                                <x-input-label for="first_name" :value="__('First Name')" />
                                <x-text-input id="first_name" name="first_name" type="text" class="mt-1 block w-full"
                                              :value="old('first_name', $user->first_name)" required autofocus />
                                <x-input-error class="mt-2" :messages="$errors->get('first_name')" />
                            </div>

                            <!-- Last Name -->
                            <div>
                                <x-input-label for="last_name" :value="__('Last Name')" />
                                <x-text-input id="last_name" name="last_name" type="text" class="mt-1 block w-full"
                                              :value="old('last_name', $user->last_name)" required />
                                <x-input-error class="mt-2" :messages="$errors->get('last_name')" />
                            </div>

                            <!-- Email -->
                            <div>
                                <x-input-label for="email" :value="__('Email')" />
                                <x-text-input id="email" name="email" type="email" class="mt-1 block w-full"
                                              :value="old('email', $user->email)" required />
                                <x-input-error class="mt-2" :messages="$errors->get('email')" />
                            </div>

                            <!-- Role -->
                            <div>
                                <x-input-label for="role" :value="__('Role')" />
                                <select id="role" name="role" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">
                                    @foreach(App\Models\UserDetails::getRoles() as $key => $role)
                                        <option value="{{ $key }}" {{ (old('role', $user->user_details->role) == $key) ? 'selected' : '' }}>
                                            {{ $role }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('role')" />
                            </div>

                            <!-- Status -->
                            <div>
                                <x-input-label for="status" :value="__('Status')" />
                                <select id="status" name="status" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">
                                    @foreach(App\Models\UserDetails::getStatuses() as $key => $status)
                                        <option value="{{ $key }}" {{ (old('status', $user->user_details->status) == $key) ? 'selected' : '' }}>
                                            {{ $status }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('status')" />
                            </div>

                            <!-- School ID -->
                            <div>
                                <x-form.input
                                    name="school_id"
                                    label="School ID"
                                    type="text"
                                    :value="old('school_id', $user->user_details->school_id)"
                                    required
                                />
                                <x-input-error :messages="$errors->get('school_id')" class="mt-1" />
                            </div>

                            <!-- Telephone -->
                            <div>
                                <x-form.input
                                    name="telephone"
                                    label="Telephone Number"
                                    type="text"
                                    :value="old('telephone', $user->user_details->telephone)"
                                    required
                                />
                                <x-input-error :messages="$errors->get('telephone')" class="mt-1" />
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

            <!-- Update Password Section -->
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                {{ __('Update Password') }}
                            </h2>
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                {{ __('Change the user’s password.') }}
                            </p>
                        </header>

                        <!-- Form for updating password -->
                        <form method="post" action="{{ route('user.password.update', $user->id) }}" class="mt-6 space-y-6">
                            @csrf
                            @method('put')

                            <!-- New Password -->
                            <div>
                                <x-input-label for="password" :value="__('New Password')" />
                                <x-text-input id="password" name="password" type="password" class="mt-1 block w-full"
                                              autocomplete="new-password" />
                                <x-input-error class="mt-2" :messages="$errors->get('password')" />
                            </div>

                            <!-- Confirm New Password -->
                            <div>
                                <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                                <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full"
                                              autocomplete="new-password" />
                                <x-input-error class="mt-2" :messages="$errors->get('password_confirmation')" />
                            </div>

                            <!-- Save Button -->
                            <div class="flex items-center gap-4">
                                <x-primary-button>{{ __('Save') }}</x-primary-button>
                                @if (session('password_success'))
                                    <p x-data="{ show: true }"
                                       x-show="show"
                                       x-transition
                                       x-init="setTimeout(() => show = false, 2000)"
                                       class="text-sm text-gray-600 dark:text-gray-400">
                                        {{ session('password_success') }}
                                    </p>
                                @endif
                            </div>
                        </form>
                    </section>
                </div>
            </div>

            <!-- Delete User Section -->
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
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
                            <form method="post" action="{{ route('user.destroy', $user->id) }}" class="p-6">
                                @csrf
                                @method('delete')

                                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                    {{ __('Are you sure you want to delete this user?') }}
                                </h2>
                                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                    {{ __('Once deleted, all of the user’s data will be permanently removed.') }}
                                </p>

                                <div class="mt-6">
                                    <x-input-label for="password" :value="__('Password')" class="sr-only" />
                                    <x-text-input id="password" name="password" type="password"
                                                  class="mt-1 block w-3/4"
                                                  placeholder="{{ __('Password') }}" />
                                    <x-input-error :messages="$errors->get('userDeletion')" class="mt-2" />
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
