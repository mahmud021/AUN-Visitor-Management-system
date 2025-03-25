<div class="flex items-center justify-between ">
    <h1 class="text-xl font-bold text-white">
        Welcome, {{ $user->user_details->user->first_name }}!
    </h1>
    <p class="text-sm text-gray-300">
        {{ $user->user_details->role }} Dashboard
    </p>

    <div class="flex items-center gap-4">
        <!-- Create Visitor Button -->
        <x-primary-button
            type="button"
            x-data
            @click="$dispatch('open-modal', 'create-visitor-modal')"
            @class([
                'bg-brand-700 hover:bg-brand-600 text-white',
                'cursor-not-allowed opacity-50' => Gate::denies('create-visitor'),
            ])
            :disabled="Gate::denies('create-visitor')"
        >
            Create Visitor
        </x-primary-button>


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

