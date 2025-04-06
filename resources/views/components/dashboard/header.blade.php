<div class="flex items-center justify-between">
    <!-- Left: Welcome Message -->
    <div>
        <h1 class="text-xl font-bold text-white">
            Welcome, {{ $user->user_details->user->first_name }}!
        </h1>
        <p class="text-sm text-gray-300">
            {{ $user->user_details->role }} Dashboard
        </p>
    </div>

    <!-- Center: Date and Time -->
    <p class="text-sm text-gray-300">
        {{ \Illuminate\Support\Carbon::now()->format('l jS, g:i A') }}
    </p>

    <!-- Right: Action Buttons -->
    <div class="flex items-center gap-4">
        <!-- Create Dropdown -->
        <!-- Create Dropdown -->
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
                    Add walk In Visitor
                </x-dropdown-link>
                <x-dropdown-link @click="$dispatch('open-modal', 'inventory-modal')">
                    Register An Appliance
                </x-dropdown-link>
            </x-slot>
        </x-dropdown>


        <!-- Logout Form -->
        <form method="POST" action="{{ route('logout') }}" class="inline">
            @csrf
            <button type="submit"
                    class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 border border-transparent rounded-md font-medium text-xs text-white uppercase tracking-widest focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                {{ __('Log Out') }}
            </button>
        </form>
    </div>
</div>


