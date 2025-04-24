<div class="flex items-center justify-between flex-col md:flex-row gap-4 md:gap-0">
    <!-- Left: Welcome Message -->
    <div>
        <h1 class="text-lg font-medium text-white">
            Welcome, {{ $user->user_details->user->first_name }}!
        </h1>
    </div>

    <!-- Center: Date and Time (Optional) -->
    <p class="text-sm text-gray-300 md:text-base hidden md:block">
        {{ \Illuminate\Support\Carbon::now()->format('g:i A') }}
    </p>

    <!-- Right: Action Buttons -->
    <div class="flex items-center gap-4">
        @role('super admin', 'HR Admin','Security')
        <a href="{{ route('visitors.scan') }}"
           class="flex items-center gap-2 px-3 py-2 border border-gray-600 rounded-lg hover:border-gray-300 transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            <svg xmlns="http://www.w3.org/2000/svg"
                 width="20"
                 height="20"
                 viewBox="0 0 24 24"
                 fill="none"
                 stroke="currentColor"
                 stroke-width="1.5"
                 stroke-linecap="round"
                 stroke-linejoin="round"
                 class="lucide lucide-scan-qr-code-icon text-white">
                <!-- Your existing SVG paths here -->
                <path d="M17 12v4a1 1 0 0 1-1 1h-4"/>
                <path d="M17 3h2a2 2 0 0 1 2 2v2"/>
                <path d="M17 8V7"/>
                <path d="M21 17v2a2 2 0 0 1-2 2h-2"/>
                <path d="M3 7V5a2 2 0 0 1 2-2h2"/>
                <path d="M7 17h.01"/>
                <path d="M7 21H5a2 2 0 0 1-2-2v-2"/>
                <rect x="7" y="7" width="5" height="5" rx="1"/>
            </svg>
            <span class="text-white text-sm font-medium">Scan QR</span>
        </a>
        @endrole
        <x-dropdown :disabled="!Gate::allows('create-visitor') && !Gate::allows('add-walk-in-visitor')">
            <x-slot name="trigger">
                <x-primary-button aria-label="Create options" aria-haspopup="true">
                    Create
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                         class="lucide-chevron-down" style="margin-left: 0.5rem;">
                        <path d="m6 9 6 6 6-6"/>
                    </svg>
                </x-primary-button>
            </x-slot>
            <x-slot name="content">
                <!-- Show Create Visitor for Students, Staff, HR Admin, Super Admin -->
                @can('create-visitor')
                    <x-dropdown-link @click="$dispatch('open-modal', 'create-visitor-modal')">
                        Create Visitor
                    </x-dropdown-link>
                @endcan

                <!-- Show Add Walk-In Visitor for Security, HR Admin, Super Admin -->
                @can('add-walk-in-visitor')
                    <x-dropdown-link @click="$dispatch('open-modal', 'walk-in-modal')">
                        Add Walk-In Visitor
                    </x-dropdown-link>
                @endcan

                <!-- Show Register Appliance for Students, Staff, HR Admin, Super Admin -->
                @can('create-inventory')
                    <x-dropdown-link @click="$dispatch('open-modal', 'inventory-modal')">
                        Register Appliance
                    </x-dropdown-link>
                @endcan
            </x-slot>
        </x-dropdown>
    </div>
</div>
