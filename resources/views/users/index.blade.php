<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Users') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Table Section -->
            <x-table-wrapper>
                <x-table-header title="Users" description="Add users, edit and more.">
                    <x-slot name="actions">
                        <x-primary-button type="button"
                                          aria-haspopup="dialog" aria-expanded="false"
                                          aria-controls="hs-scale-animation-modal"
                                          data-hs-overlay="#hs-scale-animation-modal">
                            Create User
                        </x-primary-button>
                        <form method="POST" action="/user">
                            @csrf
                            <x-modal.wrapper id="hs-scale-animation-modal">
                                <x-modal.header title="Create User" modalId="hs-scale-animation-modal"/>

                                <div class="p-4 overflow-y-auto">
                                    <div class="grid grid-cols-1 gap-4 lg:gap-4"> <!-- Adjusted gap here -->
                                        <!-- First Name -->
                                        <div class="space-y-2"> <!-- Add space-y-2 for uniform spacing -->
                                            <x-form.input name="first_name" label="First Name" type="text" value="{{ old('first_name') }}"/>
                                            <x-input-error :messages="$errors->get('first_name')" class="mt-1"/> <!-- Reduced margin-top -->
                                        </div>

                                        <!-- Last Name -->
                                        <div class="space-y-2">
                                            <x-form.input name="last_name" label="Last Name" type="text" value="{{ old('last_name') }}"/>
                                            <x-input-error :messages="$errors->get('last_name')" class="mt-1"/>
                                        </div>

                                        <!-- Email -->
                                        <div class="space-y-2">
                                            <x-form.input name="email" label="AUN Email" type="email" value="{{ old('email') }}"/>
                                            <x-input-error :messages="$errors->get('email')" class="mt-1"/>
                                        </div>

                                        <!-- Password -->
                                        <div class="space-y-2">
                                            <x-form.input name="password" label="Password" type="password" required autocomplete="new-password"/>
                                            <x-input-error :messages="$errors->get('password')" class="mt-1"/>
                                        </div>

                                        <!-- Telephone -->
                                        <div class="space-y-2">
                                            <x-form.input name="telephone" label="Telephone Number" type="text" value="{{ old('telephone') }}"/>
                                            <x-input-error :messages="$errors->get('telephone')" class="mt-1"/>
                                        </div>

                                        <!-- School ID -->
                                        <div class="space-y-2">
                                            <x-form.input name="school_id" label="ID number" type="text" value="{{ old('school_id') }}"/>
                                            <x-input-error :messages="$errors->get('school_id')" class="mt-1"/>
                                        </div>

                                        <!-- Role Select -->
                                        <div class="space-y-2">
                                            <x-form.select name="role" label="Select Role">
                                                <option selected disabled>Open this select menu</option>
                                                @foreach (App\Models\UserDetails::getRoles() as $value => $label)
                                                    <option value="{{ $value }}" {{ old('role') == $value ? 'selected' : '' }}>
                                                        {{ $label }}
                                                    </option>
                                                @endforeach
                                            </x-form.select>
                                            <x-input-error :messages="$errors->get('role')" class="mt-1"/>

                                        </div>

                                        <div class="space-y-2">
                                            <x-form.select name="status" label="Select Status">
                                                <option selected disabled>Open this select menu</option>
                                                @foreach (App\Models\UserDetails::getStatuses() as $value => $label)
                                                    <option value="{{ $value }}" {{ old('status') == $value ? 'selected' : '' }}>
                                                        {{ $label }}
                                                    </option>
                                                @endforeach
                                            </x-form.select>
                                            <x-input-error :messages="$errors->get('status')" class="mt-1"/>
                                        </div>

                                    </div>
                                </div>

                                <x-modal.footer>
                                    <x-primary-button type="submit">
                                        Submit
                                    </x-primary-button>
                                </x-modal.footer>
                            </x-modal.wrapper>
                        </form>

                    </x-slot>
                </x-table-header>

                <x-table>
                    <x-slot name="header">
                        <tr>
                            <th scope="col" class="ps-6 py-3 text-start"></th>
                            <th scope="col" class="ps-6 lg:ps-3 xl:ps-0 pe-6 py-3 text-start">
                                <div class="flex items-center gap-x-2">
                                    <span
                                        class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-neutral-200">Name</span>
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3 text-start">
                                <div class="flex items-center gap-x-2">
                                    <span
                                        class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-neutral-200">Role</span>
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3 text-start">
                                <div class="flex items-center gap-x-2">
                                    <span
                                        class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-neutral-200">Status</span>
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3 text-start">
                                <div class="flex items-center gap-x-2">
                                    <span
                                        class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-neutral-200">Telephone</span>
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3 text-start">
                                <div class="flex items-center gap-x-2">
                                    <span
                                        class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-neutral-200">Created</span>
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3 text-end"></th>
                        </tr>
                    </x-slot>

                    <x-slot name="rows">
                        @foreach ($users as $user)
                            <x-table-row>
                                <td class="size-px whitespace-nowrap"></td>
                                <td class="size-px whitespace-nowrap">
                                    <div class="ps-6 lg:ps-3 xl:ps-0 pe-6 py-3">
                                        <div class="flex items-center gap-x-3">
                                            <div class="grow">
                         <span class="block text-sm font-semibold text-gray-800 dark:text-neutral-200">
                             {{ $user->first_name ?? 'Null'}} {{ $user->last_name ?? 'Null' }}
                         </span>
                                                <span
                                                    class="block text-sm text-gray-500 dark:text-neutral-500">{{ $user->email ?? 'Null' }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="h-px w-72 whitespace-nowrap">
                                    <div class="px-6 py-3">
                                        <span
                                            class="block text-sm font-semibold text-gray-800 dark:text-neutral-200">{{ $user->user_details->role ?? 'Null'}}</span>
                                        <span
                                            class="block text-sm text-gray-500 dark:text-neutral-500">{{ $user->user_details->school_id ?? 'Null' }}</span>
                                    </div>
                                </td>
                                <td class="size-px whitespace-nowrap">
                                    <div class="px-6 py-3">
                                        <x-status-badge status="{{ $user->user_details->status ?? 'Null' }}"/>
                                    </div>
                                </td>
                                <td class="size-px whitespace-nowrap">
                                    <div class="px-6 py-3">
                                        <div class="flex items-center gap-x-3">
                                            <span
                                                class="block text-sm font-semibold text-gray-800 dark:text-neutral-200">0{{ $user->user_details->telephone ?? 'Null' }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="size-px whitespace-nowrap">
                                    <div class="px-6 py-3">
                                        <span class="text-sm text-gray-500 dark:text-neutral-500">
                                            {{ \Carbon\Carbon::parse($user->created_at)->format('d M, Y') }}
                                        </span></div>
                                </td>
                                <td class="size-px whitespace-nowrap">

                                    <div class="px-6 py-2">
                                        <div class="hs-dropdown [--placement:bottom-right] relative inline-block">
                                            <button id="hs-table-dropdown-{{ $user->id }}" type="button" class="hs-dropdown-toggle py-1.5 px-2 inline-flex justify-center items-center gap-2 rounded-lg text-gray-700 dark:text-neutral-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-600 text-sm" aria-haspopup="menu" aria-expanded="false" aria-label="Dropdown">
                                                <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <circle cx="12" cy="12" r="1"/>
                                                    <circle cx="19" cy="12" r="1"/>
                                                    <circle cx="5" cy="12" r="1"/>
                                                </svg>
                                            </button>
                                            <div class="hs-dropdown-menu transition-[opacity,margin] duration hs-dropdown-open:opacity-100 opacity-0 hidden divide-y divide-gray-200 min-w-40 z-20 bg-white shadow-2xl rounded-lg p-2 mt-2 dark:divide-neutral-700 dark:bg-neutral-800 dark:border dark:border-neutral-700" role="menu" aria-orientation="vertical" aria-labelledby="hs-table-dropdown-1">
                                                <div class="py-2 first:pt-0 last:pb-0">
                          <span class="block py-2 px-3 text-xs font-medium uppercase text-gray-400 dark:text-neutral-600">
                            Actions
                          </span>
                                                    <a class="flex items-center gap-x-3 py-2 px-3 rounded-lg text-sm text-gray-800 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 dark:text-neutral-400 dark:hover:bg-neutral-700 dark:hover:text-neutral-300 dark:focus:bg-neutral-700 dark:focus:text-neutral-300" href="/user/{{ $user['id'] }}" >
                                                       Edit
                                                    </a>
                                                    <a class="flex items-center gap-x-3 py-2 px-3 rounded-lg text-sm text-gray-800 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 dark:text-neutral-400 dark:hover:bg-neutral-700 dark:hover:text-neutral-300 dark:focus:bg-neutral-700 dark:focus:text-neutral-300" href="{{ route('user.visitorLogs', $user->id) }}">
                                                        View Visitor Logs
                                                    </a>
                                                    <a class="flex items-center gap-x-3 py-2 px-3 rounded-lg text-sm text-gray-800 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 dark:text-neutral-400 dark:hover:bg-neutral-700 dark:hover:text-neutral-300 dark:focus:bg-neutral-700 dark:focus:text-neutral-300" href="#">
                                                        View Activity Logs
                                                    </a>
                                                    <a class="flex items-center gap-x-3 py-2 px-3 rounded-lg text-sm text-gray-800 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 dark:text-neutral-400 dark:hover:bg-neutral-700 dark:hover:text-neutral-300 dark:focus:bg-neutral-700 dark:focus:text-neutral-300" href="#">
                                                        Export User Data
                                                    </a>
                                                </div>
                                                <div class="py-2 first:pt-0 last:pb-0">
                                                    <a class="flex items-center gap-x-3 py-2 px-3 rounded-lg text-sm text-red-600 hover:bg-gray-100 focus:ring-2 focus:ring-blue-500 dark:text-red-500 dark:hover:bg-neutral-700 dark:hover:text-neutral-300" href="#">
                                                        Delete
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
{{--                                    <div class="px-6 py-1.5">--}}
{{--                                        <x-action-button href="/user/{{ $user['id'] }}" label="Edit"/>--}}
{{--                                    </div>--}}
                                </td>
                            </x-table-row>
                        @endforeach
                    </x-slot>
                </x-table>

                <x-table-footer totalResults="">
                    <x-slot name="pagination">
                        {{ $users->links() }}
                    </x-slot>

                </x-table-footer>
            </x-table-wrapper>
            <!-- End Table Section -->


        </div>


    </div>

</x-app-layout>
