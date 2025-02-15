<!-- Sidebar Component: resources/views/components/sidebar.blade.php -->

<!-- Breadcrumb (Mobile only) -->
<div class="sticky top-0 inset-x-0 z-20 bg-white border-y px-4 sm:px-6 lg:px-8 lg:hidden dark:bg-neutral-800 dark:border-neutral-700">
    <div class="flex items-center py-2">
        <!-- Navigation Toggle -->
        <button type="button"
                class="size-8 flex justify-center items-center gap-x-2 border border-gray-200 text-gray-800 hover:text-gray-500 rounded-lg focus:outline-none focus:text-gray-500 disabled:opacity-50 disabled:pointer-events-none dark:border-neutral-700 dark:text-neutral-200 dark:hover:text-neutral-500 dark:focus:text-neutral-500"
                aria-haspopup="dialog" aria-expanded="false" aria-controls="hs-application-sidebar"
                aria-label="Toggle navigation" data-hs-overlay="#hs-application-sidebar">
            <span class="sr-only">Toggle Navigation</span>
            <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                 viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                 stroke-linecap="round" stroke-linejoin="round">
                <rect width="18" height="18" x="3" y="3" rx="2"/>
                <path d="M15 3v18"/>
                <path d="m8 9 3 3-3 3"/>
            </svg>
        </button>
        <!-- End Navigation Toggle -->

        <!-- Breadcrumb -->
        <ol class="ms-3 flex items-center whitespace-nowrap">
            <li class="flex items-center text-sm text-gray-800 dark:text-neutral-400">
                Application Layout
                <svg class="shrink-0 mx-3 overflow-visible size-2.5 text-gray-400 dark:text-neutral-500"
                     width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M5 1L10.6869 7.16086C10.8637 7.35239 10.8637 7.64761 10.6869 7.83914L5 14"
                          stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                </svg>
            </li>
            <li class="text-sm font-semibold text-gray-800 truncate dark:text-neutral-400" aria-current="page">
                Dashboard
            </li>
        </ol>
        <!-- End Breadcrumb -->
    </div>
</div>
<!-- End Breadcrumb -->

<!-- Sidebar Container -->
<div id="hs-application-sidebar"
     class="hs-overlay [--auto-close:lg] hs-overlay-open:translate-x-0 -translate-x-full transition-all duration-300 transform
            w-[260px] h-full hidden fixed inset-y-0 start-0 z-[60] bg-gray-900 lg:block lg:translate-x-0 lg:end-auto lg:bottom-0
            dark:bg-neutral-800 dark:border-neutral-700"
     role="dialog" tabindex="-1" aria-label="Sidebar">
    <div class="relative flex flex-col h-full max-h-full">

        <!-- Logo Section -->
        <div class="px-6 pt-4 flex items-center">
            <a href="{{ route('dashboard') }}"
               class="flex-none rounded-xl text-xl inline-block font-semibold focus:outline-none focus:opacity-80">
                <x-application-logo class="w-28 h-auto dark:fill-white"/>
            </a>
        </div>
        <!-- End Logo Section -->

        <!-- Header / Account Dropdown -->
        <div class="mt-auto p-2 border-y border-gray-200 dark:border-neutral-700">
            <div class="hs-dropdown [--strategy:absolute] [--auto-close:inside] relative w-full inline-flex">
                <button id="hs-sidebar-header-example-with-dropdown" type="button"
                        class="w-full inline-flex shrink-0 items-center gap-x-2 p-2 text-start text-sm text-gray-800 rounded-md
                       hover:bg-gray-100 focus:outline-none focus:bg-gray-100 dark:text-neutral-200 dark:hover:bg-neutral-700 dark:focus:bg-neutral-700"
                        aria-haspopup="menu" aria-expanded="false" aria-label="Dropdown">
                    {{ Auth::user()->first_name . ' ' . Auth::user()->last_name }}
                    <svg class="shrink-0 size-3.5 ms-auto" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                         viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                         stroke-linejoin="round">
                        <path d="m7 15 5 5 5-5"/>
                        <path d="m7 9 5-5 5 5"/>
                    </svg>
                </button>

                <!-- Account Dropdown Menu -->
                <div class="hs-dropdown-menu hs-dropdown-open:opacity-100 w-60 transition-[opacity,margin] duration opacity-0 hidden z-20
                    bg-white border border-gray-200 rounded-lg shadow-lg dark:bg-neutral-900 dark:border-neutral-700"
                     role="menu" aria-orientation="vertical" aria-labelledby="hs-sidebar-header-example-with-dropdown">
                    <div class="p-1">
                        <a class="flex items-center gap-x-3 py-2 px-3 rounded-lg text-sm text-gray-800 hover:bg-gray-100
                      disabled:opacity-50 disabled:pointer-events-none focus:outline-none focus:bg-gray-100 dark:text-neutral-300 dark:hover:bg-neutral-800 dark:focus:bg-neutral-800"
                           href="{{ route('profile.edit') }}">
                            {{ __('Profile') }}
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                             onclick="event.preventDefault(); this.closest('form').submit();"
                                             class="flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-red-600 hover:bg-red-50 dark:hover:bg-red-500/10">
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
                [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-300
                dark:[&::-webkit-scrollbar-track]:bg-neutral-700 dark:[&::-webkit-scrollbar-thumb]:bg-neutral-500">
            <nav class="hs-accordion-group p-3 w-full flex flex-col flex-wrap" data-hs-accordion-always-open>
                <ul class="flex flex-col space-y-1">
                    <li>
                        <x-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                            <svg class="shrink-0 size-4" ...></svg>
                            Dashboard
                        </x-nav-link>
                    </li>
                    <li>
                        <x-nav-link href="{{ route('user.index') }}" :active="request()->routeIs('user.index')">                            <svg class="shrink-0 size-4" ...></svg>
                            Users
                        </x-nav-link>
                    </li>
                    <li>
                        <x-nav-link href="{{ route('visitors.index') }}" :active="request()->routeIs('visitors.index')">
                            <svg class="shrink-0 size-4" ...></svg>
                            Visitors
                        </x-nav-link>
                    </li>
                    <li>
                        <x-nav-link href="{{ route('appointment') }}" :active="request()->routeIs('appointment')">
                            <svg class="shrink-0 size-4" ...></svg>
                            Appointments
                        </x-nav-link>
                    </li>
                </ul>
            </nav>
        </div>
        <!-- End Menu Items -->
    </div>
</div>
<!-- End Sidebar Container -->
