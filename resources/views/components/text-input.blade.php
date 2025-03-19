@props(['disabled' => false, 'value' => ''])

<input
    @disabled($disabled)
    value="{{ $value }}"
    {{ $attributes->merge(['class' => 'border-gray-300 dark:border-neutral-700 bg-brand-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm']) }}
>
