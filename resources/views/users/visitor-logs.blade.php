<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('User Information and Logs') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div>
                <div class="px-4 sm:px-0">
                    <h3 class="text-base/7 font-semibold text-brand-50"></h3>
                    <p class="mt-1 max-w-2xl text-sm/6 text-brand-300">Personal details and application.</p>
                </div>
                <div class="mt-6 border-t border-brand-800 ">
                    <dl class="divide-y divide-brand-800">
                        <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                            <dt class="text-sm/6 font-medium text-brand-50">Full name</dt>
                            <dd class="mt-1 text-sm/6 text-brand-200 sm:col-span-2 sm:mt-0">{{$user->first_name}} {{$user->last_name}}</dd>
                        </div>
                        <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                            <dt class="text-sm/6 font-medium text-brand-50">Email address</dt>
                            <dd class="mt-1 text-sm/6 text-brand-200 sm:col-span-2 sm:mt-0">{{$user->email}}</dd>
                        </div>
                        <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                            <dt class="text-sm/6 font-medium text-brand-50">School ID</dt>
                            <dd class="mt-1 text-sm/6 text-brand-200 sm:col-span-2 sm:mt-0">{{$user->user_details->school_id}}</dd>
                        </div>

                        <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                            <dt class="text-sm/6 font-medium text-brand-50">Role</dt>
                            <dd class="mt-1 text-sm/6 text-brand-200 sm:col-span-2 sm:mt-0">{{$user->user_details->role}}</dd>
                        </div>
                        <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                            <dt class="text-sm/6 font-medium text-brand-50">Telephone</dt>
                            <dd class="mt-1 text-sm/6 text-brand-200 sm:col-span-2 sm:mt-0">{{$user->user_details->telephone}}</dd>
                        </div>
                        <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                            <dt class="text-sm/6 font-medium text-brand-50">Blacklist status</dt>
                            <dd class="mt-1 text-sm/6 text-brand-200 sm:col-span-2 sm:mt-0">True</dd>
                            <dt class="text-sm/6 font-medium text-brand-50">Bypass HR Approval</dt>
                            <dd class="mt-1 text-sm/6 text-brand-200 sm:col-span-2 sm:mt-0">True</dd>

                        </div>
                        <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">


                        </div>

                    </dl>
                </div>
            </div>
            <div class="flex justify-center">
                <div class="flex bg-gray-100 hover:bg-gray-200 rounded-lg transition p-1 dark:bg-neutral-700 dark:hover:bg-neutral-600">
                    <nav class="flex justify-center gap-x-1" aria-label="Tabs" role="tablist" aria-orientation="horizontal">
                        <button type="button" class="hs-tab-active:bg-white hs-tab-active:text-gray-700 hs-tab-active:dark:bg-neutral-800 hs-tab-active:dark:text-neutral-400 dark:hs-tab-active:bg-gray-800 py-3 px-4 inline-flex items-center gap-x-2 bg-transparent text-sm text-gray-500 hover:text-gray-700 focus:outline-hidden focus:text-gray-700 font-medium rounded-lg hover:text-blue-600 disabled:opacity-50 disabled:pointer-events-none dark:text-neutral-400 dark:hover:text-white dark:focus:text-white active" id="segment-item-1" aria-selected="true" data-hs-tab="#segment-1" aria-controls="segment-1" role="tab">
                           Visitor Logs
                        </button>
                        <button type="button" class="hs-tab-active:bg-white hs-tab-active:text-gray-700 hs-tab-active:dark:bg-neutral-800 hs-tab-active:dark:text-neutral-400 dark:hs-tab-active:bg-gray-800 py-3 px-4 inline-flex items-center gap-x-2 bg-transparent text-sm text-gray-500 hover:text-gray-700 focus:outline-hidden focus:text-gray-700 font-medium rounded-lg hover:text-blue-600 disabled:opacity-50 disabled:pointer-events-none dark:text-neutral-400 dark:hover:text-white dark:focus:text-white" id="segment-item-2" aria-selected="false" data-hs-tab="#segment-2" aria-controls="segment-2" role="tab">
                           Inventory Logs
                        </button>
                        <button type="button" class="hs-tab-active:bg-white hs-tab-active:text-gray-700 hs-tab-active:dark:bg-neutral-800 hs-tab-active:dark:text-neutral-400 dark:hs-tab-active:bg-gray-800 py-3 px-4 inline-flex items-center gap-x-2 bg-transparent text-sm text-gray-500 hover:text-gray-700 focus:outline-hidden focus:text-gray-700 font-medium rounded-lg hover:text-blue-600 disabled:opacity-50 disabled:pointer-events-none dark:text-neutral-400 dark:hover:text-white dark:focus:text-white" id="segment-item-3" aria-selected="false" data-hs-tab="#segment-3" aria-controls="segment-3" role="tab">
                            Tab 3
                        </button>
                    </nav>
                </div>
            </div>

            <div class="mt-3 text-center">
                <div id="segment-1" role="tabpanel" aria-labelledby="segment-item-1">
                    <x-table-wrapper>
                        <x-table-header
                            title=""
                            description="Here are the visitors for this user."
                        >
                            <x-slot name="actions">
                                <!-- If you want any actions like "Add new visitor" for this user -->
                            </x-slot>
                        </x-table-header>

                        <x-table>
                            <x-slot name="header">
                                <tr>
                                    <th scope="col" class="ps-6 py-3 text-start"></th>
                                    <th scope="col" class="ps-6 lg:ps-3 xl:ps-0 pe-6 py-3 text-start">
                                        <div class="flex items-center gap-x-2">
                                    <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-neutral-200">
                                        Visitor Name
                                    </span>
                                        </div>
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-start">
                                        <div class="flex items-center gap-x-2">
                                    <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-neutral-200">
                                        Telephone
                                    </span>
                                        </div>
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-start">
                                        <div class="flex items-center gap-x-2">
                                    <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-neutral-200">
                                        Expected Arrival
                                    </span>
                                        </div>
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-start">
                                        <div class="flex items-center gap-x-2">
                                    <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-neutral-200">
                                        Created
                                    </span>
                                        </div>
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-end"></th>
                                </tr>
                            </x-slot>

                            <x-slot name="rows">
                                @foreach ($visitors as $visitor)
                                    <x-table-row>
                                        <td class="size-px whitespace-nowrap"></td>
                                        <td class="size-px whitespace-nowrap">
                                            <div class="ps-6 lg:ps-3 xl:ps-0 pe-6 py-3">
                                                <div class="flex items-center gap-x-3">
                                                    <div class="grow">
                                                <span class="block text-sm font-semibold text-gray-800 dark:text-neutral-200">
                                                    {{ $visitor->first_name }} {{ $visitor->last_name }}
                                                </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="h-px w-72 whitespace-nowrap">
                                            <div class="px-6 py-3">
                                        <span class="block text-sm font-semibold text-gray-800 dark:text-neutral-200">
                                            {{ $visitor->telephone }}
                                        </span>
                                            </div>
                                        </td>
                                        <td class="size-px whitespace-nowrap">
                                            <div class="px-6 py-3">
                                        <span class="block text-sm font-semibold text-gray-800 dark:text-neutral-200">
                                            {{ $visitor->expected_arrival }}
                                        </span>
                                            </div>
                                        </td>
                                        <td class="size-px whitespace-nowrap">
                                            <div class="px-6 py-3">
                                        <span class="text-sm text-gray-500 dark:text-neutral-500">
                                            {{ \Carbon\Carbon::parse($visitor->created_at)->format('d M, Y') }}
                                        </span>
                                            </div>
                                        </td>
                                        <td class="size-px whitespace-nowrap">
                                            <!-- Optional: Actions for each visitor -->
                                        </td>
                                    </x-table-row>
                                @endforeach
                            </x-slot>
                        </x-table>

                        <x-table-footer totalResults="">
                            <x-slot name="pagination">
                                <!-- Add pagination if needed -->
                                {{ $visitors->links() }}
                            </x-slot>
                        </x-table-footer>
                    </x-table-wrapper>
                </div>
                <div id="segment-2" class="hidden" role="tabpanel" aria-labelledby="segment-item-2">
                    <p class="text-gray-500 dark:text-neutral-400">
                        This is the <em class="font-semibold text-gray-800 dark:text-neutral-200">second</em> item's tab body.
                    </p>
                </div>
                <div id="segment-3" class="hidden" role="tabpanel" aria-labelledby="segment-item-3">
                    <p class="text-gray-500 dark:text-neutral-400">
                        This is the <em class="font-semibold text-gray-800 dark:text-neutral-200">third</em> item's tab body.
                    </p>
                </div>
            </div>



        </div>
    </div>
</x-app-layout>
