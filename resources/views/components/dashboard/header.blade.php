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
        <x-dropdown :disabled="!Gate::allows('create-visitor') && !Gate::allows('add-walk-in-visitor')">
            <x-slot name="trigger">
                <x-primary-button aria-label="Create options" aria-haspopup="true">
                    Create
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide-chevron-down" style="margin-left: 0.5rem;">
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
