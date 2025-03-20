@props(['disabled' => false, 'value' => ''])

<input
    @disabled($disabled)
    value="{{ $value }}"
    {{ $attributes->merge([
        'class' => 'border-neutral-700 bg-brand-900 text-gray-300 focus:border-indigo-600 focus:ring-indigo-600 rounded-md shadow-sm'
    ]) }}
>
