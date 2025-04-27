{{-- Generic dark-mode card wrapper --}}
<div
    {{ $attributes->merge([
        'class' => '
            relative flex flex-col gap-y-3
            p-5 rounded-xl
            bg-neutral-900/60 text-gray-100
            ring-1 ring-neutral-800 shadow-sm
            transition hover:ring-blue-600 focus-within:ring-blue-600
        ',
    ]) }}
>
    {{ $slot }}
</div>
