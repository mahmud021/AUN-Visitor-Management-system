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
            <div class="p-4 sm:p-8  bg-brand-900 shadow sm:rounded-lg">
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

                        <form method="post" action="{{ route('user.update', $user->id) }}" class="mt-6 space-y-6">
                            @csrf
                            @method('patch')

                            <!-- First Name -->
                            <div>
                                <x-input-label for="first_name" :value="__('First Name')"/>
                                <x-text-input id="first_name" name="first_name" type="text" class="mt-1 block w-full"
                                              :value="old('first_name', $user->first_name)" required autofocus/>
                                <x-input-error class="mt-2" :messages="$errors->get('first_name')"/>
                            </div>

                            <!-- Last Name -->
                            <div>
                                <x-input-label for="last_name" :value="__('Last Name')"/>
                                <x-text-input id="last_name" name="last_name" type="text" class="mt-1 block w-full"
                                              :value="old('last_name', $user->last_name)" required/>
                                <x-input-error class="mt-2" :messages="$errors->get('last_name')"/>
                            </div>

                            <!-- Email -->
                            <div>
                                <x-input-label for="email" :value="__('Email')"/>
                                <x-text-input id="email" name="email" type="email" class="mt-1 block w-full"
                                              :value="old('email', $user->email)" required/>
                                <x-input-error class="mt-2" :messages="$errors->get('email')"/>
                            </div>

                            <!-- Role -->
                            <div class="space-y-2">
                                <x-form.select name="role" label="Select Role">
                                    <option selected disabled>Open this select menu</option>
                                    @foreach (App\Models\UserDetails::getRoles() as $value => $label)
                                        <option value="{{ $value }}"
                                            {{ (old('role', $user->user_details->role ?? '') == $value) ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </x-form.select>
                                <x-input-error :messages="$errors->get('role')" class="mt-1"/>
                            </div>

                            <!-- Status -->
                            <div class="space-y-2">
                                <x-form.select name="status" label="Select Status">
                                    <option selected disabled>Open this select menu</option>
                                    @foreach (App\Models\UserDetails::getStatuses() as $value => $label)
                                        <option value="{{ $value }}"
                                            {{ (old('status', $user->user_details->status ?? '') == $value) ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </x-form.select>
                                <x-input-error :messages="$errors->get('status')" class="mt-1"/>
                            </div>

                            <!-- School ID -->
                            <div>
                                <x-input-label for="school_id" :value="__('School ID')"/>
                                <x-text-input id="school_id" name="school_id" type="text" class="mt-1 block w-full"
                                              :value="old('school_id', $user->user_details->school_id)" required/>
                                <x-input-error class="mt-2" :messages="$errors->get('school_id')"/>
                            </div>

                            <!-- Telephone -->
                            <div>
                                <x-input-label for="telephone" :value="__('Telephone Number')"/>
                                <x-text-input id="telephone" name="telephone" type="text" class="mt-1 block w-full"
                                              :value="old('telephone', $user->user_details->telephone)" required/>
                                <x-input-error class="mt-2" :messages="$errors->get('telephone')"/>
                            </div>
                            <!-- Blacklist Toggle -->
                            <div class="flex items-center">
                                <!-- Hidden input for false value -->
                                <input type="hidden" name="blacklist" value="0">
                                <!-- Toggle Switch -->
                                <input type="checkbox"
                                       id="blacklist"
                                       name="blacklist"
                                       value="1"
                                       class="relative w-[3.25rem] h-7 p-px bg-gray-100 border-transparent text-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:ring-blue-600 disabled:opacity-50 disabled:pointer-events-none checked:bg-none checked:text-blue-600 checked:border-blue-600 focus:checked:border-blue-600 dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-600 before:inline-block before:content-[''] before:size-6 before:bg-white checked:before:bg-blue-200 before:translate-x-0 checked:before:translate-x-full before:rounded-full before:shadow before:transform before:ring-0 before:transition before:ease-in-out before:duration-200 dark:before:bg-neutral-400 dark:checked:before:bg-blue-200"
                                    @checked(old('blacklist', $user->user_details->blacklist ?? false))>
                                <!-- Screen reader label -->
                                <label for="blacklist" class="sr-only">Toggle blacklist status</label>
                                <!-- Visible label -->
                                <span class="text-sm text-gray-500 ms-3 dark:text-gray-400">Blacklist User</span>
                            </div>

                            <!-- Bypass HR Approval Toggle -->
                            <div class="flex items-center mt-4">
                                <!-- Hidden input for false value -->
                                <input type="hidden" name="bypass_hr_approval" value="0">
                                <!-- Toggle Switch -->
                                <input type="checkbox"
                                       id="bypass_hr_approval"
                                       name="bypass_hr_approval"
                                       value="1"
                                       class="relative w-[3.25rem] h-7 p-px bg-gray-100 border-transparent text-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:ring-blue-600 disabled:opacity-50 disabled:pointer-events-none checked:bg-none checked:text-blue-600 checked:border-blue-600 focus:checked:border-blue-600 dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-600 before:inline-block before:content-[''] before:size-6 before:bg-white checked:before:bg-blue-200 before:translate-x-0 checked:before:translate-x-full before:rounded-full before:shadow before:transform before:ring-0 before:transition before:ease-in-out before:duration-200 dark:before:bg-neutral-400 dark:checked:before:bg-blue-200"
                                    @checked(old('bypass_hr_approval', $user->user_details->bypass_hr_approval ?? false))>
                                <!-- Screen reader label -->
                                <label for="bypass_hr_approval" class="sr-only">Toggle bypass HR approval</label>
                                <!-- Visible label -->
                                <span class="text-sm text-gray-500 ms-3 dark:text-gray-400">Bypass HR Approval</span>
                            </div>

                            <!-- Allow Late Check-In Toggle -->
                            <div class="flex items-center mt-4">
                                <!-- Hidden input for false value -->
                                <input type="hidden" name="bypass_late_checkin" value="0">

                                <!-- Toggle Switch -->
                                <input type="checkbox"
                                       id="bypass_late_checkin"
                                       name="bypass_late_checkin"
                                       value="1"
                                       class="relative w-[3.25rem] h-7 p-px bg-gray-100 border-transparent text-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:ring-blue-600 disabled:opacity-50 disabled:pointer-events-none checked:bg-none checked:text-blue-600 checked:border-blue-600 focus:checked:border-blue-600 dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-600 before:inline-block before:content-[''] before:size-6 before:bg-white checked:before:bg-blue-200 before:translate-x-0 checked:before:translate-x-full before:rounded-full before:shadow before:transform before:ring-0 before:transition before:ease-in-out before:duration-200 dark:before:bg-neutral-400 dark:checked:before:bg-blue-200"
                                    @checked(old('bypass_late_checkin', $user->user_details->bypass_late_checkin ?? false))>

                                <!-- Screen reader label -->
                                <label for="bypass_late_checkin" class="sr-only">Toggle allow late check-in</label>

                                <!-- Visible label -->
                                <span class="text-sm text-gray-500 ms-3 dark:text-gray-400">Allow Late Check-In</span>
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
            <div class="p-4 sm:p-8 bg-brand-900 shadow sm:rounded-lg">
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
                        <form method="post" action="{{ route('user.password.update', $user->id) }}"
                              class="mt-6 space-y-6">
                            @csrf
                            @method('put')

                            <!-- New Password -->
                            <div>
                                <x-input-label for="password" :value="__('New Password')"/>
                                <x-text-input id="password" name="password" type="password" class="mt-1 block w-full"
                                              autocomplete="new-password"/>
                                <x-input-error class="mt-2" :messages="$errors->get('password')"/>
                            </div>

                            <!-- Confirm New Password -->
                            <div>
                                <x-input-label for="password_confirmation" :value="__('Confirm Password')"/>
                                <x-text-input id="password_confirmation" name="password_confirmation" type="password"
                                              class="mt-1 block w-full"
                                              autocomplete="new-password"/>
                                <x-input-error class="mt-2" :messages="$errors->get('password_confirmation')"/>
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
