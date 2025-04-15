<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-neutral-200 leading-tight">
            {{ __('Users') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Table Section -->
            <x-table-wrapper>
                <x-table-header title="Users" description="Add users, edit and more.">
                    <x-slot name="actions">

                            <div class="relative max-w-xs">
                                <label for="hs-table-search" class="sr-only">Search</label>
                                <form action="{{ route('user.search') }}" method="GET">
                                    <input type="text" name="q" class="py-1.5 sm:py-2 px-3 ps-9 block w-full border-gray-200 shadow-2xs rounded-lg sm:text-sm focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600" placeholder="Search Users">
                                </form>
                                    <div class="absolute inset-y-0 start-0 flex items-center pointer-events-none ps-3">
                                    <svg class="size-4 text-gray-400 dark:text-neutral-500" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <circle cx="11" cy="11" r="8"></circle>
                                        <path d="m21 21-4.3-4.3"></path>
                                    </svg>
                                </div>
                            </div>
                        <!-- Reset Search Button -->
                        @if(request()->has('q')) <!-- Show Reset button if there's a query -->
                        <form action="{{ route('user.index') }}" method="GET">
                            <x-primary-button type="submit" >
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-list-restart-icon lucide-list-restart"><path d="M21 6H3"/><path d="M7 12H3"/><path d="M7 18H3"/><path d="M12 18a5 5 0 0 0 9-3 4.5 4.5 0 0 0-4.5-4.5c-1.33 0-2.54.54-3.41 1.41L11 14"/><path d="M11 10v4h4"/></svg>                            </x-primary-button>
                        </form>
                        @endif
                        <x-primary-button
                            type="button"
                            x-data
                            @click="$dispatch('open-modal', 'create-user-modal')"
                            class="bg-brand-700 hover:bg-brand-600 text-white"
                        >
                            Create User
                        </x-primary-button>

                        <x-modal name="create-user-modal" maxWidth="lg">
                            <div class="p-4 bg-brand-900 text-brand-100 overflow-y-auto">
                                <h3 class="text-xl font-semibold mb-4">Create User</h3>

                                <form method="POST" action="/user">
                                    @csrf

                                    <div class="grid grid-cols-2 gap-4 lg:gap-4">
                                        <!-- First Name -->
                                        <div class="space-y-2">
                                            <x-form.input name="first_name" label="First Name" type="text"
                                                          value="{{ old('first_name') }}"
                                                          class="bg-brand-800 border-brand-700 text-brand-100 placeholder-brand-300"/>
                                            <x-input-error :messages="$errors->get('first_name')" class="mt-1 text-brand-400"/>
                                        </div>

                                        <!-- Last Name -->
                                        <div class="space-y-2">
                                            <x-form.input name="last_name" label="Last Name" type="text"
                                                          value="{{ old('last_name') }}"
                                                          class="bg-brand-800 border-brand-700 text-brand-100 placeholder-brand-300"/>
                                            <x-input-error :messages="$errors->get('last_name')" class="mt-1 text-brand-400"/>
                                        </div>

                                        <!-- Email -->
                                        <div class="col-span-2 space-y-2">
                                            <x-form.input name="email" label="AUN Email" type="email"
                                                          value="{{ old('email') }}"
                                                          class="bg-brand-800 border-brand-700 text-brand-100 placeholder-brand-300"/>
                                            <x-input-error :messages="$errors->get('email')" class="mt-1 text-brand-400"/>
                                        </div>

                                        <!-- Password -->
                                        <div class="col-span-2 space-y-2">
                                            <x-form.input name="password" label="Password" type="password" required
                                                          autocomplete="new-password"
                                                          class="bg-brand-800 border-brand-700 text-brand-100 placeholder-brand-300"/>
                                            <x-input-error :messages="$errors->get('password')" class="mt-1 text-brand-400"/>
                                        </div>

                                        <!-- Telephone -->
                                        <div class="space-y-2">
                                            <x-form.input name="telephone" label="Telephone Number" type="text"
                                                          value="{{ old('telephone') }}"
                                                          class="bg-brand-800 border-brand-700 text-brand-100 placeholder-brand-300"/>
                                            <x-input-error :messages="$errors->get('telephone')" class="mt-1 text-brand-400"/>
                                        </div>

                                        <!-- School ID -->
                                        <div class="space-y-2">
                                            <x-form.input name="school_id" label="ID Number" type="text"
                                                          value="{{ old('school_id') }}"
                                                          class="bg-brand-800 border-brand-700 text-brand-100 placeholder-brand-300"/>
                                            <x-input-error :messages="$errors->get('school_id')" class="mt-1 text-brand-400"/>
                                        </div>

                                        <!-- Role -->
                                        <div class="space-y-2">
                                            <x-form.select name="role" label="Select Role"
                                                           class="bg-brand-800 border-brand-700 text-brand-100">
                                                <option selected disabled>Open this select menu</option>
                                                @foreach (App\Models\UserDetails::getRoles() as $value => $label)
                                                    <option value="{{ $value }}" {{ old('role') == $value ? 'selected' : '' }}>
                                                        {{ $label }}
                                                    </option>
                                                @endforeach
                                            </x-form.select>
                                            <x-input-error :messages="$errors->get('role')" class="mt-1 text-brand-400"/>
                                        </div>

                                        <!-- Status -->
                                        <div class="space-y-2">
                                            <x-form.select name="status" label="Select Status"
                                                           class="bg-brand-800 border-brand-700 text-brand-100">
                                                <option selected disabled>Open this select menu</option>
                                                @foreach (App\Models\UserDetails::getStatuses() as $value => $label)
                                                    <option value="{{ $value }}" {{ old('status') == $value ? 'selected' : '' }}>
                                                        {{ $label }}
                                                    </option>
                                                @endforeach
                                            </x-form.select>
                                            <x-input-error :messages="$errors->get('status')" class="mt-1 text-brand-400"/>
                                        </div>
                                    </div>

                                    <!-- Modal Footer -->
                                    <div class="mt-6 flex justify-end gap-x-2 bg-brand-900 py-3 px-4 rounded-md border-t border-brand-700">
                                        <button type="button"
                                                class="px-4 py-2 bg-brand-700 hover:bg-brand-600 text-white rounded-md transition"
                                                @click.prevent="$dispatch('close-modal', 'create-user-modal')">
                                            Cancel
                                        </button>

                                        <x-primary-button type="submit" class="bg-brand-700 hover:bg-brand-600 text-white">
                                            Submit
                                        </x-primary-button>
                                    </div>
                                </form>
                            </div>
                        </x-modal>

                    </x-slot>
                </x-table-header>

                <x-table>
                    <x-slot name="header">
                        <tr>
                            <th scope="col" class="ps-6 py-3 text-start"></th>
                            <th scope="col" class="ps-6 lg:ps-3 xl:ps-0 pe-6 py-3 text-start">
                                <div class="flex items-center gap-x-2">
                                    <span class="text-xs font-semibold uppercase tracking-wide text-neutral-200">
                                        Name
                                    </span>
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3 text-start">
                                <div class="flex items-center gap-x-2">
                                    <span class="text-xs font-semibold uppercase tracking-wide text-neutral-200">
                                        Role
                                    </span>
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3 text-start">
                                <div class="flex items-center gap-x-2">
                                    <span class="text-xs font-semibold uppercase tracking-wide text-neutral-200">
                                        Status
                                    </span>
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3 text-start">
                                <div class="flex items-center gap-x-2">
                                    <span class="text-xs font-semibold uppercase tracking-wide text-neutral-200">
                                        Telephone
                                    </span>
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3 text-start">
                                <div class="flex items-center gap-x-2">
                                    <span class="text-xs font-semibold uppercase tracking-wide text-neutral-200">
                                        Created
                                    </span>
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
                                                <span class="block text-sm font-semibold text-neutral-200">
                                                    {{ $user->first_name ?? 'Null'}} {{ $user->last_name ?? 'Null' }}
                                                </span>
                                                <span class="block text-sm text-neutral-500">
                                                    {{ $user->email ?? 'Null' }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="h-px w-72 whitespace-nowrap">
                                    <div class="px-6 py-3">
                                        <span class="block text-sm font-semibold text-neutral-200">{{ $user->user_details->role ?? 'Null'}}</span>
                                        <span class="block text-sm text-neutral-500">{{ $user->user_details->school_id ?? 'Null' }}</span>
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
                                            <span class="block text-sm font-semibold text-neutral-200">{{ $user->user_details->telephone ?? 'Null' }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="size-px whitespace-nowrap">
                                    <div class="px-6 py-3">
                                        <span class="text-sm text-neutral-500">
                                            {{ \Carbon\Carbon::parse($user->created_at)->format('d M, Y') }}
                                        </span>
                                    </div>
                                </td>
                                <td class="size-px whitespace-nowrap">
                                    <div class="px-6 py-2">
                                        <div class="hs-dropdown [--placement:bottom-right] relative inline-block">
                                            <button id="hs-table-dropdown-{{ $user->id }}" type="button" class="hs-dropdown-toggle py-1.5 px-2 inline-flex justify-center items-center gap-2 rounded-lg text-neutral-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-600 text-sm" aria-haspopup="menu" aria-expanded="false" aria-label="Dropdown">
                                                <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <circle cx="12" cy="12" r="1"/>
                                                    <circle cx="19" cy="12" r="1"/>
                                                    <circle cx="5" cy="12" r="1"/>
                                                </svg>
                                            </button>
                                            <div class="hs-dropdown-menu transition-[opacity,margin] duration hs-dropdown-open:opacity-100 opacity-0 hidden divide-y divide-neutral-700 min-w-40 z-20 bg-neutral-800 shadow-2xl rounded-lg p-2 mt-2 border border-neutral-700" role="menu" aria-orientation="vertical" aria-labelledby="hs-table-dropdown-1">
                                                <div class="py-2 first:pt-0 last:pb-0">
                                                    <span class="block py-2 px-3 text-xs font-medium uppercase text-neutral-400">
                                                        Actions
                                                    </span>
                                                    <a href="/user/{{ $user['id'] }}" class="flex items-center gap-x-3 py-2 px-3 rounded-lg text-sm text-neutral-200 hover:bg-neutral-700 focus:outline-none focus:bg-neutral-700">
                                                        View Info and Logs
                                                    </a>
                                                    <a class="flex items-center gap-x-3 py-2 px-3 rounded-lg text-sm text-neutral-200 hover:bg-neutral-700 focus:outline-none focus:bg-neutral-700"
                                                       href="{{ route('user.edit', $user->id) }}">
                                                       Edit User Details
                                                    </a>
                                                </div>
                                                <div class="py-2 first:pt-0 last:pb-0">
                                                    <a class="flex items-center gap-x-3 py-2 px-3 rounded-lg text-sm text-red-500 hover:bg-neutral-700 focus:outline-none focus:bg-neutral-700" href="#">
                                                        Delete
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- <div class="px-6 py-1.5">
                                        <x-action-button href="/user/{{ $user['id'] }}" label="Edit"/>
                                    </div> --}}
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
