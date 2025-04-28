@can('check-in-visitor', $visitor)
    <!-- Check-in Form -->
    <form action="{{ route('visitors.checkin', $visitor) }}" method="POST" class="inline">
        @csrf
        @method('PATCH')

        <div class="flex items-center gap-2 mb-4">
            <x-primary-button class="bg-gray-700 hover:bg-gray-600 text-white">
                Check In
            </x-primary-button>
        </div>

        <div>
            <label for="visitor_code" class="block text-sm font-medium mb-2">
                Enter Visitor Code
            </label>

            <div class="py-2 px-3 bg-brand-900 border border-brand-700 rounded-lg">
                <div class="flex gap-x-3" data-hs-pin-input='{"availableCharsRE": "^[0-9]+$"}'>
                    @for ($i = 1; $i <= 4; $i++)
                        <input
                            id="visitor_code_{{ $i }}"
                            class="w-8 h-8 text-sm text-center p-0 border-brand-700 rounded-md focus:border-brand-500 focus:ring-brand-500 bg-brand-900 text-brand-200 [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none"
                            type="text"
                            placeholder="○"
                            data-hs-pin-input-item
                            {{ $i === 1 ? 'autofocus' : '' }}
                            name="visitor_code[]"
                            required
                        >
                    @endfor
                </div>
            </div>
        </div>
    </form>
@else
    @can('view-all-visitors')
        <span class="text-red-400">Check-in is not allowed at this time.</span>
    @endcan
@endcan
