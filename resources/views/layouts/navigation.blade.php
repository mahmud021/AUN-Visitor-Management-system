<!-- Sidebar Component: resources/views/components/sidebar.blade.php -->

<!-- Breadcrumb (Mobile only) -->
<div class="sticky top-0 inset-x-0 z-20 border-y px-4 sm:px-6 lg:px-8 lg:hidden bg-brand-900 border-neutral-700">
    <div class="flex items-center py-2">
        <!-- Navigation Toggle -->
        <button type="button"
                class="size-8 flex justify-center items-center gap-x-2 text-neutral-200 hover:bg-brand-900 focus:outline-none focus:bg-brand-900 disabled:opacity-50 disabled:pointer-events-none"
                aria-haspopup="dialog" aria-expanded="false" aria-controls="hs-application-sidebar"
                aria-label="Toggle navigation" data-hs-overlay="#hs-application-sidebar">
            <span class="sr-only">Toggle Navigation</span>
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-menu-icon lucide-menu"><line x1="4" x2="20" y1="12" y2="12"/><line x1="4" x2="20" y1="6" y2="6"/><line x1="4" x2="20" y1="18" y2="18"/></svg>
        </button>
        <!-- End Navigation Toggle -->

        <!-- Breadcrumb -->
{{--        <ol class="ms-3 flex items-center whitespace-nowrap">--}}
{{--            <li class="flex items-center text-sm text-neutral-200">--}}
{{--                Application Layout--}}
{{--                <svg class="shrink-0 mx-3 overflow-visible size-2.5 text-neutral-500"--}}
{{--                     width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">--}}
{{--                    <path d="M5 1L10.6869 7.16086C10.8637 7.35239 10.8637 7.64761 10.6869 7.83914L5 14"--}}
{{--                          stroke="currentColor" stroke-width="2" stroke-linecap="round"/>--}}
{{--                </svg>--}}
{{--            </li>--}}
{{--            <li class="text-sm font-semibold text-neutral-200 truncate" aria-current="page">--}}
{{--                Dashboard--}}
{{--            </li>--}}
{{--        </ol>--}}
        <!-- End Breadcrumb -->
    </div>
</div>
<!-- End Breadcrumb -->

<!-- Sidebar Container -->
<div id="hs-application-sidebar"
     class="hs-overlay [--auto-close:lg] hs-overlay-open:translate-x-0 -translate-x-full transition-all duration-300 transform
            w-[260px] h-full hidden fixed inset-y-0 start-0 z-[60] bg-brand-900 lg:block lg:translate-x-0 lg:end-auto lg:bottom-0 border-neutral-700"
     role="dialog" tabindex="-1" aria-label="Sidebar">
    <div class="relative flex flex-col h-full max-h-full">

        <!-- Logo Section -->
        <div class="px-6 pt-6 pb-2 flex flex-col items-center">
            <a href="{{ route('dashboard') }}"
               class="flex-none rounded-xl text-xl inline-block font-semibold focus:outline-none focus:opacity-80">
                <img src="{{ asset('images/logo.svg') }}" class="w-32 h-auto invert mx-auto" alt="AUN Logo">
            </a>
        </div>
        <!-- End Logo Section -->

        <!-- Header / Account Dropdown -->
        <div class="mt-auto p-2 border-y border-neutral-700">
            <div class="hs-dropdown [--strategy:absolute] [--auto-close:inside] relative w-full inline-flex">
                <button id="hs-sidebar-header-example-with-dropdown" type="button"
                        class="w-full inline-flex shrink-0 items-center gap-x-2 p-2 text-start text-sm text-neutral-200 rounded-md hover:bg-brand-900 focus:outline-none focus:bg-brand-900"
                        aria-haspopup="menu" aria-expanded="false" aria-label="Dropdown">
                    {{ Auth::user()->first_name . ' ' . Auth::user()->last_name }}
                    <svg class="shrink-0 size-3.5 ms-auto" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                         viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                         stroke-linecap="round" stroke-linejoin="round">
                        <path d="m7 15 5 5 5-5"/>
                        <path d="m7 9 5-5 5 5"/>
                    </svg>
                </button>

                <!-- Account Dropdown Menu -->
                <div
                    class="hs-dropdown-menu hs-dropdown-open:opacity-100 w-60 transition-[opacity,margin] duration opacity-0 hidden z-20 bg-brand-900 border border-neutral-700 rounded-lg shadow-lg"
                    role="menu" aria-orientation="vertical" aria-labelledby="hs-sidebar-header-example-with-dropdown">
                    <div class="p-1">
                        <a class="flex items-center gap-x-3 py-2 px-3 rounded-lg text-sm text-neutral-200 hover:bg-brand-900 focus:outline-none focus:bg-brand-900"
                           href="/user/{{ auth()->user()->id }}">
                            {{ __('Profile') }}
                        </a>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                             onclick="event.preventDefault(); this.closest('form').submit();"
                                             class="flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-red-600 hover:bg-brand-900">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </div>
                </div>
                <!-- End Account Dropdown Menu -->
            </div>
        </div>
        <!-- End Header / Account Dropdown -->

        <!-- Menu Items -->
        <div class="h-full overflow-y-auto
                [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full
                [&::-webkit-scrollbar-track]:bg-brand-900 [&::-webkit-scrollbar-thumb]:bg-brand-900">
            <nav class="hs-accordion-group p-3 w-full flex flex-col flex-wrap" data-hs-accordion-always-open>
                <ul class="flex flex-col space-y-1">
                    <li>
                        <x-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                 viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                 stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-house">
                                <path d="M15 21v-8a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1v8"/>
                                <path
                                    d="M3 10a2 2 0 0 1 .709-1.528l7-5.999a2 2 0 0 1 2.582 0l7 5.999A2 2 0 0 1 21 10v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                            </svg>
                            Dashboard
                        </x-nav-link>
                    </li>
                    <li>
                        <x-nav-link href="{{ route('user.index') }}" :active="request()->routeIs('user.index')">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                 viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                 stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user-pen">
                                <path d="M11.5 15H7a4 4 0 0 0-4 4v2"/>
                                <path
                                    d="M21.378 16.626a1 1 0 0 0-3.004-3.004l-4.01 4.012a2 2 0 0 0-.506.854l-.837 2.87a.5.5 0 0 0 .62.62l2.87-.837a2 2 0 0 0 .854-.506z"/>
                                <circle cx="10" cy="7" r="4"/>
                            </svg>
                            Users
                        </x-nav-link>
                    </li>
                    <li>
                        <x-nav-link href="{{ route('visitors.index') }}" :active="request()->routeIs('visitors.index')">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                 viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                 stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-users-round">
                                <path d="M18 21a8 8 0 0 0-16 0"/>
                                <circle cx="10" cy="8" r="5"/>
                                <path d="M22 20c0-3.37-2-6.5-4-8a5 5 0 0 0-.45-8.3"/>
                            </svg>
                            Visitors
                        </x-nav-link>
                    </li>
                    <li>
                        <x-nav-link href="{{ route('inventory.index') }}"
                                    :active="request()->routeIs('inventory.index')">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round"
                                 stroke-linejoin="round" class="lucide lucide-notebook-pen">
                                <path d="M13.4 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-7.4"/>
                                <path d="M2 6h4"/>
                                <path d="M2 10h4"/>
                                <path d="M2 14h4"/>
                                <path d="M2 18h4"/>
                                <path
                                    d="M21.378 5.626a1 1 0 1 0-3.004-3.004l-5.01 5.012a2 2 0 0 0-.506.854l-.837 2.87a.5.5 0 0 0 .62.62l2.87-.837a2 2 0 0 0 .854-.506z"/>
                            </svg>
                            Inventory
                        </x-nav-link>
                    </li>
                    <li>
                        <x-nav-link href="{{ route('settings.edit') }}"
                                    :active="request()->routeIs('settings.edit')">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                 stroke-linejoin="round" class="lucide lucide-settings-icon lucide-settings">
                                <path
                                    d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.09a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z"/>
                                <circle cx="12" cy="12" r="3"/>
                            </svg>
                            App settings
                        </x-nav-link>
                    </li>
                    {{--                    <li>--}}
                    {{--                        <x-nav-link href="{{ route('analytics.index') }}" :active="request()->routeIs('analytics.index')">--}}
                    {{--                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"--}}
                    {{--                                 viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"--}}
                    {{--                                 stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-users-round">--}}
                    {{--                                <path d="M18 21a8 8 0 0 0-16 0"/>--}}
                    {{--                                <circle cx="10" cy="8" r="5"/>--}}
                    {{--                                <path d="M22 20c0-3.37-2-6.5-4-8a5 5 0 0 0-.45-8.3"/>--}}
                    {{--                            </svg>--}}
                    {{--                            Analytics--}}
                    {{--                        </x-nav-link>--}}
                    {{--                    </li>--}}
                    {{-- Other nav items --}}
                </ul>
            </nav>
        </div>
        <!-- End Menu Items -->
    </div>
</div>
<!-- End Sidebar Container -->
