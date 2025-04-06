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
        <x-dropdown :disabled="!Gate::allows('create-visitor')">
            <x-slot name="trigger">
                <x-primary-button>
Create
                </x-primary-button>
            </x-slot>
            <x-slot name="content">
                <x-dropdown-link @click="$dispatch('open-modal', 'create-visitor-modal')">
                    Create Visitor
                </x-dropdown-link>
                <x-dropdown-link @click="$dispatch('open-modal', 'walk-in-modal')">
                    Add Walk-In Visitor
                </x-dropdown-link>
                <x-dropdown-link @click="$dispatch('open-modal', 'inventory-modal')">
                    Register Appliance
                </x-dropdown-link>
            </x-slot>
        </x-dropdown>
    </div>
</div>
