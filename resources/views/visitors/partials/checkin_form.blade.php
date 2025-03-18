<!-- Check-in Form -->
<form action="{{ route('visitors.update', $visitor->id) }}" method="POST" class="inline">
    @csrf
    @method('PATCH')
    <input type="hidden" name="status" value="checked_in">
    <input type="hidden" name="redirect_to" value="{{ route('dashboard') }}">

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
            <div class="flex gap-x-3" data-hs-pin-input>
                @for ($i = 1; $i <= 4; $i++)
                    <input
                        id="visitor_code_{{ $i }}"
                        class="w-8 h-8 text-sm text-center p-0 border-brand-700 rounded-md focus:border-brand-500 focus:ring-brand-500 bg-brand-900 text-brand-200"
                        type="text"
                        placeholder="○"
                        data-hs-pin-input-item
                        {{ $i === 1 ? 'autofocus' : '' }}
                        name="visitor_code[]"
                    >
                @endfor
            </div>
        </div>
    </div>
</form>
